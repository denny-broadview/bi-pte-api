<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userSubscriptions extends Model
{
    use HasFactory;
    protected $table = 'users_subscriptions';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscriptions::class, 'subscription_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'payment_id');
    }
}
