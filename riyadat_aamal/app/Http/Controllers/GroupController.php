<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\group;
use App\group_participant;

// Notification real time function in helper
use App\Helper\Helper;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        //some functions can only be executed by group admin/owner
        $this->middleware('owner')->only(['edit', 'update', 'delete', 'remove_user']);

        //the group will only be accessed by a member  message
        $this->middleware('member')->only('show');
    }

    //display form to create a group //-- show create Group Page
    public function create_form()
    {
        return view('group.create');
    }
    // create New Group
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        //generate a code for the groupe
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($characters), rand(0, 9), 7);
       // insert New Group to Table
        $group = group::create([
            'name' => $request->name,
            'code' => $code,
            'admin_id' => auth()->user()->id,
        ]);

        //we attach the user with the group after he created it
       $group->participants()->attach(auth()->user()->id,['etat_participation' => 'valider']);

        return redirect()->route('chat_groupe')->with('message', 'Your group has been created');
    }

    //display the form to join a group
    public function join_form()
    {
        return view('group.join');
    }
    //display the form to join a group
    public function confirmer_demande()
    {
        $Users = DB::table('entreprise')
        ->join('group_participants', 'entreprise.id', '=', 'group_participants.user_id')
        ->join('groups', 'group_participants.group_id', '=', 'groups.id')
        ->select('entreprise.*', 'group_participants.group_id', 'groups.name as group_name')
        ->where('groups.admin_id',Auth::id())->where('group_participants.etat_participation','en attente')
        ->paginate(9);

        return view('group.confirmer_demande',compact('Users'));
    }
    //change the name of the group
    public function valider_demande(Request $request)
    {
        $this->validate($request, [
            'id_user' => 'required',
            'id_group' => 'required'
        ]);
        $group=group::find($request->id_group);
        group_participant::where('group_id', $request->id_group)
        ->where('user_id', $request->id_user)
        ->update(['etat_participation' => 'valider']);

        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has confirmed your request to join '.$group->name.' ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $request->id_user,"chat_group");
        return redirect()->route('chat_groupe')->with('message', 'You have confirmed the request !');
    }
    //change the name of the group
    public function supprimer_demande(Request $request)
    {
        $this->validate($request, [
            'id_user' => 'required',
            'id_group' => 'required'
        ]);
        $group=group::find($request->id_group);
        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has refused your request to join '.$group->name.' ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $request->id_user,"chat_group");
        $deleted = group_participant::where('group_id', $request->id_group)->where('user_id',$request->id_user)->delete();
        return redirect()->route('chat_groupe')->with('message', 'You deleted the request !');
    }

    //user join a group by entering the code
    public function join(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $code = $request->code;
        $group = group::where('code', $code)->first();

        //if the group exists
        if ($group)
        {
            try
            {
                //we add the user to the group and we redirect him to the home page with a success message
                $group->participants()->attach(auth()->user()->id);
                // notification
                $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> asked join in group ('.$group->name.') ';
                Helper::RealTime_Notifications(Auth::id(), $message_notification, $group->admin_id,"chat_group");

                return redirect()->route('chat_groupe')->with('message', 'you asked to join in group ('.$group->name.')');
            }
            catch (\Throwable $th)
            {
                //Display an error if the user is already in the group
                return redirect()->back()->with('message', 'You are already a member of this group');
            }
        }
        else
        {
            //if the group doesn't exist we throw an error
            return redirect()->back()->with('message', 'Group not found');
        }
    }

    //display the form to edit the name of a group
    public function edit($id)
    {
        $group = group::find($id);
        return view('group.edit', compact('group'));
    }

    //change the name of the group
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $group = group::find($id);
        $old_name=$group->name;
        $group->name = $request->name;
        $group->save();
        $group_members = $group->participants()->where('etat_participation','valider')->where('user_id','<>',Auth::id())->get();
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has changed the name of the group from '.$old_name.' to '.$request->name.' ';
        // send notification to all users
        foreach ($group_members as $user) Helper::RealTime_Notifications(Auth::id(), $message_notification, $user->id,"chat_group");

        return redirect()->route('chat_groupe')->with('message', 'Group name has been changed');
    }

    //delete a groupe and remove every participant
    public function deleteGroup(Request $request)
    {
        $group = group::find($request->id);
        $group_members = $group->participants()->where('etat_participation','valider')->where('user_id','<>',Auth::id())->get();
        $group->participants()->detach();  // remove all subscribers from this Group
        $group->delete();
        $group->messages()->delete();  // remove all messages from this Group
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has deleted the group ('.$group->name.') ';
        // send notification to all users

        foreach ($group_members as $user) Helper::RealTime_Notifications(Auth::id(), $message_notification, $user->id,"chat_group");
        return redirect()->route('chat_groupe')->with('message', 'Group has been deleted');
    }

    //display the members of a group, the admin can then decide who to remove
    public function members_list($id)
    {
        $group = group::find($id);
        $group_members = $group->participants()->where('etat_participation','valider')->where('user_id','<>',Auth::id())->paginate(9);
        $group_id = $id;

        return view('group.members_list', compact(['group_members', 'group_id','group']));
    }

    //remove the user from a group
    public function remove_user($id, Request $request)
    {
        $group = group::find($id);
        $group->participants()->detach($request->user_id);

        // notification
        $message_notification = '<strong class="notify_users">'.Auth::user()->name.'</strong> has get you out from the group ('.$group->name.') ';
        Helper::RealTime_Notifications(Auth::id(), $message_notification, $request->user_id,"chat_group");

        return redirect()->back()->with('message', 'A user has been removed');
    }

}
