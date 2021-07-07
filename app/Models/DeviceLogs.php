<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLogs extends Model
{
    use HasFactory;
    protected $table = 'device_logs';
    protected $fillable = [
        'user_id',
        'browser_name',
        'device_name',
        'ip_address',
        'login_time',
        'status'
    ];
    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
