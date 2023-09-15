<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Recommandation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// Notification real time function in helper
use App\Helper\Helper;

class RecommandationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recommandations=Recommandation::where(function ($query) { $query->where('id_entreprise', Auth::id())->orWhere('id_entreprise_recom', Auth::id()); })->get();
        return view('entreprise.MesRecommandations')->with('recommandations',$recommandations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title"=>['required','string'],
            "id_entreprise_recom"=>['required','integer'],
            ],
            [
                'title.required' => 'titre est obligatoire!',
                'id_entreprise_recom.required' => 'id entreprise est obligatoire!',
            ]
        );
        $number_recommandation=Recommandation::where('id_entreprise_recom',$request->id_entreprise_recom)->count();

        if($number_recommandation>=5) return redirect()->back()->with("message","company you recommend has exceeded recommendation limit (5 recommendations) !!!");
        else{
            Recommandation::create([
                'title'=>$request->title,
                'id_entreprise'=>Auth::id(),
                'id_entreprise_recom'=>$request->id_entreprise_recom,
             ]);

            // notification
            $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> asked for a recommendation for a project  ';
            Helper::RealTime_Notifications(Auth::id(), $message_notification, $request->id_entreprise_recom,"recommendation");
            return redirect()->back()->with('message', 'You have successfully recommended');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entreprise_recom=User::find($id);
        $recommandations=Recommandation::where('id_entreprise_recom',$id)->where('etat_recom','valider-commenter')->paginate(5);
        $count_projects=Recommandation::where('id_entreprise_recom',$id)->
        where(function ($query) { $query->where('etat_recom', 'valider')->orWhere('etat_recom', 'valider-commenter'); })
        ->count();
        return view('entreprise.recommandation')->with('entreprise_recom',$entreprise_recom)->with('recommandations',$recommandations)->with('count_projects',$count_projects);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$param)     // Valider recommandation
    {
        $recommandation=Recommandation::find($request->id);
        $recommandation->etat_recom = 'valider';
        $recommandation->save();

        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has confirmed your request for a recommendation for a project  ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $recommandation->id_entreprise,"recommendation");
        return redirect()->back()->with('message', 'You have successfully validated a recommendation');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $param)  //commenter et rating d'un recommendation
    {
        $request->validate([
            "comment"=>['required','string'],
            "rating"=>['required','integer'],
            ],
            [
                'comment.required' => 'comment est obligatoire!',
                'rating.required' => 'rating est obligatoire!',
            ]
        );
        $recommandation = Recommandation::find($request->id_recom);
        $recommandation->comment = $request->comment;
        $recommandation->rating = $request->rating;
        $recommandation->etat_recom = 'valider-commenter';
        $recommandation->save();
        $count= (int) Recommandation::where('id_entreprise_recom',$recommandation->id_entreprise_recom)->where('etat_recom','valider-commenter')->avg('rating');
        User::where('id',$recommandation->id_entreprise_recom )->update(['rating' => $count]);

        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has commented and given his rating for recommendation ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $recommandation->id_entreprise_recom,"recommendation");
        return redirect()->back()->with('message', 'You have commented successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $recommandation = Recommandation::find($request->id);
        Recommandation::destroy($request->id);

        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has refused your request for a recommendation for a project ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $recommandation->id_entreprise,"recommendation");
        return redirect()->back()->with('message', 'You have successfully deleted a recommendation');
    }
}
