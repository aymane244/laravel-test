<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\message;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    // show all groups that User is Follow
    public function index()
    {
    // select all Users + count how many message are unread from the selected user
        $users = DB::select("select entreprise.id, entreprise.name, entreprise.email,entreprise.logo, count(is_read) as unread
        from entreprise LEFT  JOIN  messages ON entreprise.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        where entreprise.isAdmin=false and entreprise.etat_compte=true and entreprise.id != " . Auth::id() . "
        group by entreprise.id, entreprise.name, entreprise.email,entreprise.logo");

        return view('entreprise.chat', ['users' => $users]);
    }
    // get all Messages
    public function getMessage($user_id)
    {
    // try {
            $my_id = Auth::id();

            // Make read all unread message sent
            Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

            // Get all message from selected user
            $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
            })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
            })->get();

            return view('messages.index', ['messages' => $messages]);
        // } catch (\Throwable $th) {
        //     return $th;
        // }
    }

   // send new message
    public function sendMessage(Request $request)
    {
        // try{
            $from = Auth::id();
            $to = $request->receiver_id;
            $message = $request->message;
            $data = new message();
            $data->from = $from;
            $data->to = $to;
            $data->message = $message;

            if($request->file_message != "not_exist"){
                $image=$request->file('file_message');
                $new_name=rand().'.'.$image->getClientOriginalExtension();
                $data->file_message = $new_name;
                $image->move('files/', $new_name);
            }
            else $data->file_message = '';

            $data->is_read = 0; // message will be unread when sending message
            $data->save();
        
            // return $message;
            return $this->sendRequest($from, $message, $to);
            
            // } catch (\Throwable $th) {
            // return $th;
            // }
    }

    public function sendRequest($from, $message, $to){
        $users = DB::select("SELECT * FROM messages WHERE messages.to = " . Auth::id() . " ");
        if(isset($users)){
            foreach ($users as $p) {
                $Data = $p->to;
            }}
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => false
            );
        $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
        // notification
        $data = ['from' => $from, 'to' => $to];
        $notify = 'notify-channel';
        $pusher->trigger($notify, 'App\\Events\\Notify', $data);
    }
  }
