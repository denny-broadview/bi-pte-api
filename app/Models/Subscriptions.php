<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    protected $fillable = [
        'role_id',
        'title',
        'students_allowed',
        'description',
        'monthly_price',
        'quarterly_price',
        'halfyearly_price',
        'annually_price',
        'white_labelling_price',
        'mock_tests',
        'practice_tests',
        'practice_questions',
        'videos',
        'prediction_files',
        'status'
    ];

    public function userSubscriptions()
    {
        return $this->hasMany('App\Models\userSubscriptions');
    }

}
