<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Contact;
use App\notification;
use App\Recommandation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EntrepriseUpdateRequest as EntrepriseUpdateRequest;

class EntrepriseController extends Controller
{
    
    
    public function lang($lang){
        if($lang=="fr") return redirect()->back()->with('lang','fr');
        if($lang=="ar") return redirect()->back()->with('lang','ar');
        if($lang=="ang") return redirect()->back();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entreprises = User::where('etat_compte',true)->where('isAdmin',false)->orderBy('rating', 'desc')->paginate(9);
        return view('entreprise.entreprises')->with('entreprises',$entreprises);
    }

    public function contact(Request $request){

        $request->validate([
            "full_name"=>['required','string'],
            "email"=>['required','email'],
            "subject"=>['required','string'],
            "message"=>['required','string'],
            ],
            [
                'full_name.required' => 'Nom est obligatoire!',
                'email.required' => 'email est obligatoire!',
                'subject.required' => 'objet est obligatoire!',
                'message.required' => 'message est obligatoire!',
            ]
        );
        contact::create([
            'nom_complet'=>$request->full_name,
            'email'=>$request->email,
            'objet'=>$request->subject,
            'message'=>$request->message,
        ]);
        return redirect()->back()->with('message', 'you contacted support !!!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
    public function show($param)
    {
        $count_projects=Recommandation::where('id_entreprise_recom',Auth::id())->
        where(function ($query) { $query->where('etat_recom', 'valider')->orWhere('etat_recom', 'valider-commenter'); })
        ->count();
        return view('entreprise.profile')->with('count_projects',$count_projects);
    }

    public function edit($param)
    {
        return view('entreprise.edit');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EntrepriseUpdateRequest $request,$param)
    {
        if(Auth::user()->logo==null) $new_name=null;
        else $new_name=Auth::user()->logo;
        if($request->logo!=null){
            $image=$request->file('logo');
            $new_name=rand().'.'.$image->getClientOriginalExtension();
            $image->move('img/logos', $new_name);
        }
        $entreprise=Auth::user();
        $entreprise->name = $request->name;
        $entreprise->tele = $request->tele;
        $entreprise->adress = $request->adress;
        $entreprise->logo = $new_name;
        $entreprise->email = $request->email;
        $entreprise->type_entreprise = $request->type_entreprise;
        $entreprise->num_rc = $request->num_rc;
        $entreprise->ide_fiscal = $request->ide_fiscal;
        $entreprise->num_ice = $request->num_ice;
        $entreprise->num_cnss = $request->num_cnss;
        $entreprise->website = $request->website;
        $entreprise->facebook = $request->facebook;
        $entreprise->instagram = $request->instagram;
        $entreprise->save();
        return redirect()->route('entreprises.show','Profile')->with("message","Informations updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function calendar(){
        return view('entreprise.calender');
    }

    public function notifications(){
        notification::where('to',Auth::id())->where('is_read',false)->update(['is_read' => true]);
    }


    public function notify(){
        $notifys = notification::where('to', Auth::id())->orderBy('is_read', 'asc')->orderBy('date', 'desc')->paginate(20);
        return view('entreprise.notifications')->with('notifys',$notifys);
    }
}
