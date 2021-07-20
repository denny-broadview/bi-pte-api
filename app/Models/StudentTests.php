<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTests extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'student_tests';
    protected $fillable = [
    	'user_id',
    	'test_id',
    	'status',
    	'start_date',
    	'end_date'
    ];

    public function user() 
    {
        return  $this->belongsTo('App\Models\User', 'user_id');
    }

    public function test() 
    {
        return  $this->belongsTo('App\Models\Tests', 'test_id');
    }
}
