<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Requests\EventsPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
// Notification real time function in helper
use App\Helper\Helper;

class EventsController extends Controller
{

    public $id;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  //affichage events
    {
        $events=Event::
        where(function ($query) { $query->where('id_entreprise', Auth::id())->orWhere('id_entreprise_rendez_vous', Auth::id()); })
        ->where(function ($query) {$query->where('etat_rendez_vous', 'valider')->orWhere('etat_rendez_vous', null); })
        ->paginate(11);
        return view('entreprise.events')->with('events',$events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()    //affichage randez-vous
    {
        $rendez_vous=Event::where('etat_rendez_vous','en attente')
        ->where(function ($query) { $query->where('id_entreprise', Auth::id())->orWhere('id_entreprise_rendez_vous', Auth::id()); })
        ->get();
        return view('entreprise.rendez_vous')->with('rendez_vous',$rendez_vous);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->id=Str::uuid();

        $request->validate([
            "id"=>['unique:events,id,'.$this->id],
            "title"=>['required','string'],
            "start"=>['required','date',],
            'end' => ['required','date','after_or_equal:start'],
            ],
            [
                'id.unique' => 'id is required!',
                'end.after_or_equal' => 'end date must be greater than start date !!!',
            ]
        );
        if ($request->exists('id_entreprise_rendez_vous')) {
            // Condition 3 rendez vous 3 fois
            $number_rendez_vous=Event::where('id_entreprise',Auth::id())->where('id_entreprise_rendez_vous',$request->id_entreprise_rendez_vous)->count();

            if($number_rendez_vous<3){
                Event::create([
                    'etat_rendez_vous'=>'en attente',
                    'id'=>$this->id,
                    'title'=>$request->title,
                    'start'=>$request->start,
                    'end'=>$request->end,
                    'id_entreprise'=>Auth::id(),
                    'id_entreprise_rendez_vous'=>$request->id_entreprise_rendez_vous,

                ]);
                
                
                // notification
                $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has requested a meeting with you ';
                Helper::RealTime_Notifications(Auth::id(), $message_notification, $request->id_entreprise_rendez_vous,"rendez_vous");
                
                
                return redirect()->back()->with('message', 'You have successfully requested a meeting');
            }
            else return redirect()->back()->with('message', 'You have exceeded your limit to request a meeting !!!');
        }
        else{
            Event::create([
                        'id'=>$this->id,
                        'title'=>$request->title,
                        'start'=>$request->start,
                        'end'=>$request->end,
                        'id_entreprise'=>Auth::user()->id,
                    ]);
            return redirect()->back()->with('message', 'You have successfully created an event');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$param)    // Valider rendez_vous
    {
        $event = Event::find($request->id);
        $event->etat_rendez_vous = 'valider';
        $event->save();
        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has confirmed your request for a meeting ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $event->id_entreprise,"rendez_vous");
        return redirect()->back()->with('message', 'You have confirmed a meeting !!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventsPostRequest $request,$param)   //update randez-vous && événement
    {
        $event = Event::find($request->id);
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->save();
        $msg='';
        if ($request->exists('etat')=="rendez_vous"){
            $msg='You have successfully updated a meeting';
            // notification
            $id=0;
            if($event->id_entreprise==Auth::id()) $id=$event->id_entreprise_rendez_vous;
            else $id=$event->id_entreprise;
            $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has updated a meeting ';
            Helper::RealTime_Notifications(Auth::id(), $message_notification, $id,"rendez_vous");
        }
        else $msg='You have successfully edited an event';

        return redirect()->back()->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $event = Event::find($request->id);
        if($event->etat_rendez_vous=='valider' || $event->etat_rendez_vous=='en attente') {
            // notification
            $id=0;
            if($event->id_entreprise==Auth::id()) $id=$event->id_entreprise_rendez_vous;
            else $id=$event->id_entreprise;
            $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has deleted a meeting ';
            Helper::RealTime_Notifications(Auth::id(), $message_notification, $id,"rendez_vous");
        }
        Event::destroy($request->id);
        return redirect()->back()->with('message', 'You have successfully deleted an event');
    }
}
