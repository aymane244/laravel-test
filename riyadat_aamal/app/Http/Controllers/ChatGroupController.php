<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\message_group;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use App\group;
use View;
use App\Events\GroupCreated;
// Notification real time function in helper
use App\Helper\Helper;

class ChatGroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    // show all groups that User is Follow
    public function index()
    {
        $my_id = Auth::id();
        $users = DB::select("select g.id, g.name,e.name as 'name_entreprise',count(mg.is_read) as 'unread'
        from message_groups mg right JOIN
            (groups g inner join group_participants gp inner join entreprise e on g.id=gp.group_id and gp.user_id=".Auth::id()." and g.admin_id=e.id )
        ON mg.group_id=g.id and mg.is_read=0 and mg.user_id=".Auth::id()."
        where gp.etat_participation='valider'
        group by g.id, g.name,name_entreprise");
        return view('group.home', compact('users'));
    }

    //  get all Channels are in App
    public function subscribe()
    {
        $groupALL = DB::select("select e.*,g.code,g.name as 'group_name' from entreprise e inner join groups g
        on g.admin_id=e.id
        where g.id not in (select group_id from group_participants where user_id=".Auth::id().")
        ");

        return view('group.join', compact('groupALL'));
    }

   // unFollow User a Channel
    public function remove_user(Request $request)
    {
        $group = group::find($request->id);  // find Channel in Group Table
        $my_id = Auth::id();        // current User
        $group->participants()->detach($my_id);  // remove User in group_participants Table
        $messages = message_group::where(['from' => $my_id])->first(); // find User in Messages Table according his Id
        if (is_array($messages) || is_object($messages)) {
            foreach($messages as $value) {
                message_group::where(['from' => $my_id])->delete();  // delete all messages of User in Messages Table
            }
        }
        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> left the group ('.$group->name.') ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $group->admin_id,"chat_group");

        return redirect()->back()->with('message', 'You are removed from groupe');;
    }

    // get messages of user according find Group
    public function getMessag($id)
    {
        $my_id = Auth::id();
        $group = group::find($id);
        // get all messages that User sent & got
        $messages = message_group::where(['group_id' => $id])->where(['user_id' => $my_id])->get();
        foreach($messages as $value) {
            message_group::where(['user_id' => $my_id])->update(['is_read' => 1]); // if User start to see messages is_read in Table update to 0
        }
        return view('messages.index_group', compact(['group', 'messages']));
    }

    // update is_read .... this function update messages is not read and update to read in Navbar
    public function getMessage($id)
    {
        $my_id = Auth::id();
        $group = group::find($id);
        $messages = message_group::where(['user_id' => $my_id])->get();
        foreach($messages as $value) {
            message_group::where(['user_id' => $my_id])->update(['is_read' => 1]);
        }
    }

   // send new message to all Followers
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);
        $to = $request->id; // this part get Group id
        $from = Auth::id();  // this part get  user id who watnts to send message
        $group = group::find($request->id);  // find group according id
        // $from = Auth::id();
        $name = Auth::user()->name;
        $group_members = $group->participants()->get();
        $new_name='';
        if($request->file_message != "not_exist"){
            $image=$request->file('file_message');
            $new_name=rand().'.'.$image->getClientOriginalExtension();
            $image->move('files/', $new_name);
        }
        else $new_name='';

         // send for all Followers
         foreach($group_members as $value) {
            $message = message_group::create(
              $data = array(
               'group_id' => $request->id,
               'user_id' => $value->id,
               'message' => $request->message,
               'file_message' => $new_name,
                'from' => $from,
               'name' => $name,
               'is_read' => 0,
               ));
               // Pusher send New message at real time
               $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
                );
            $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );
            $data = ['from' => $to, 'to' => $value->id];
            $notify = '' . $value->id .'';
            $pusher->trigger($notify, 'App\\Events\\Notify', $data);

            }
        return redirect()->back();
    }
}
