<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsAnswerData extends Model
{
    use HasFactory;
    protected $table = 'student_answer_data';
    protected $fillable = [
    	'question_id',
    	'answer_type',
    	'answer_value',
    	'student_id',
    	'time_taken'
    ];

    
}
