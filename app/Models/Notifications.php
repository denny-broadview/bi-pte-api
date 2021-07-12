<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'user_id',
        'sender_id',
        'type',
        'title',
        'body',
        'url',
        'is_read'
    ];

    public function senderDetails(){
        return  $this->belongsTo('App\Models\User', 'sender_id','id');
    }
    
    public function user() 
    {
        return  $this->belongsTo('App\Models\User', 'user_id');
    }
}
