<?php
namespace App\Helper;
use App\notification;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use Illuminate\Support\Facades\Auth;

class Helper
{
    // work with this function in all app (Controllers)

    static function RealTime_Notifications($from, $message, $to,$etat){
        $data = new notification();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->etat = $etat;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();
        
        $notifications = DB::select("SELECT * FROM notifications WHERE notifications.to = " . Auth::id() . " ");
        if(isset($notifications)){
            foreach ($notifications as $p) {
                $Data = $p->to;
            }
        }
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
        $data = ['from' => $from, 'to' => $to,'message' => $message , 'date_notify' => date("Y-m-d H:i:s"),'etat' => $etat];
        $notify = 'notification-channel';
        $pusher->trigger($notify, 'App\\Events\\NotificationEvent', $data);
    }

}
