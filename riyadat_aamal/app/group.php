<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    protected $guarded = [];
    // get admin id from user
    public function user()
        {
            return $this->belongsTo('App\User', 'admin_id');
        }

    // get Subscribers from group_participant according join to Models\User
    public function participants()
        {
            return $this->belongsToMany('App\User', 'group_participants', 'group_id', 'user_id');
        }
    // get all messages according group id from Models\Message
    public function messages()
        {
            return $this->hasMany('App\message_group', 'group_id');
        }
}
