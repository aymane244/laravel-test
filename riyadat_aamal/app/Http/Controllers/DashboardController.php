<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\Contact;
use App\Recommandation;
use App\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\DashboardPostRequest as DashboardPostRequest;


class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count_entreprise=User::where('isAdmin',false)->count();
        $count_contact=Contact::count();
        $count_type_entreprise = DB::table('entreprise')
        ->select('type_entreprise', DB::raw('count(*) as count_type'))
        ->groupBy('type_entreprise')
        ->where(function ($query) { $query->where('type_entreprise', 'Auto entrepreneur')->orWhere('type_entreprise', 'Sarl')->orWhere('type_entreprise', 'Société anonyme'); })
        ->get();
        $count_sarl=0;
        $count_anonyme=0;
        $count_entrepreneur=0;
        foreach($count_type_entreprise as $type_entreprise_numbers){
            if($type_entreprise_numbers->type_entreprise=="sarl") $count_sarl=$type_entreprise_numbers->count_type;
            if($type_entreprise_numbers->type_entreprise=="Auto entrepreneur") $count_entrepreneur=$type_entreprise_numbers->count_type;
            if($type_entreprise_numbers->type_entreprise=="Société anonyme") $count_anonyme=$type_entreprise_numbers->count_type;
        }
        $count_rendez_vous=Event::where('etat_rendez_vous','valider')->count();
        $contacts=Contact::take(7)->orderBy('date_contact', 'desc')->get();
        $entreprises_active=User::where('etat_compte',true)->where('isAdmin',false)->take(4)->get();
        $entreprises_desactive=User::where('etat_compte',false)->where('isAdmin',false)->take(5)->get();
        $count_recommandation=Recommandation::where('etat_recom', 'valider')->orWhere('etat_recom', 'valider-commenter')->count();

        return view('dashboard.index')->with('count_entreprise',$count_entreprise)
        ->with('count_contact',$count_contact)
        ->with('count_recommandation',$count_recommandation)
        ->with('count_sarl',$count_sarl)
        ->with('count_entrepreneur',$count_entrepreneur)
        ->with('count_anonyme',$count_anonyme)
        ->with('count_rendez_vous',$count_rendez_vous)
        ->with('contacts',$contacts)
        ->with('entreprises_active',$entreprises_active)
        ->with('entreprises_desactive',$entreprises_desactive);
    }

    public function contacts(){
        $contacts=Contact::paginate(10);
        return view('dashboard.contact')->with('contacts',$contacts);
    }

    public function destroy_contacts(Request $request){
        Contact::destroy($request->id);
        return redirect()->back()->with('message', 'You have successfully deleted a contact');
    }

    public function profile(){
        return view('dashboard.profile');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()     // afficher entreprise desactiver
    {
        $entreprises=User::where('etat_compte',false)->where('isAdmin',false)->get();
        return view('dashboard.entreprise_desactiver')->with('entreprises',$entreprises);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)   // afficher entreprise
    {
        $entreprises=User::where('etat_compte',true)->where('isAdmin',false)->paginate(10);
        return view('dashboard.list_entreprises')->with('entreprises',$entreprises);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)     // activer entreprise
    {
        $entreprise=User::find($request->id);
        $entreprise->etat_compte=true;
        $entreprise->save();
        return redirect()->back()->with('message', 'You have successfully validated a company');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DashboardPostRequest $request, $param)
    {
        $admin=Auth::user();
        if(Auth::user()->logo==null) $new_name=null;
        else $new_name=Auth::user()->logo;
        if($request->logo!=null){
            $image=$request->file('logo');
            $new_name=rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img/logos'), $new_name);
        }
        $admin->name = $request->name;
        $admin->logo = $new_name;
        $admin->email = $request->email;
        if($request->new_password!=null) $admin->password = Hash::make($request->new_password);
        $admin->save();
        return redirect()->back()->with('message', "You have Edit admin informations");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)    // delete entreprise
    {
        User::destroy($request->id);
        return redirect()->back()->with('message', 'You have successfully deleted a company');
    }


}
