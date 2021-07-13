<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetails extends Model
{
    use HasFactory;
    protected $table = 'student_details';
    protected $fillable = [
    	'user_id',
    	'address',
    	'user_interests',
    	'show_admin_videos',
    	'show_admin_tests',
    	'show_admin_files',
    	'show_practice_questions'
    ];

    public function user()
    {
        return $this->belongsTo(user::class,'user_id');
    }
}
