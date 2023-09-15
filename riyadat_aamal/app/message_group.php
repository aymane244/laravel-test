<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message_group extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'name',
        'user_id',
        'group_id',
        'from',
        'is_read',
        'message',
        'file_message'
    ];
    // get Group or join Models\Group in Models\Message
    public function group()
    {
        return $this->belongsTo('App\Group', 'group_id');
    }
    // join User Table
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function user_from()
    {
        return $this->hasOne('App\User','id','from');
    }

    // get date
    public function getDateTimeAttribute()
    {
        //we get the date and the time, this will return an array
        $dateAndTime = explode(' ', $this->created_at);

        $date = date('d-M-Y', strtotime($dateAndTime[0]));

        $time = date('H:i', strtotime($dateAndTime[1]));

        return "{$date} {$time}";
    }
}
