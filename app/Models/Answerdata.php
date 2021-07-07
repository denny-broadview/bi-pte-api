<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answerdata extends Model
{
    use HasFactory;
    protected $table = 'answer_data';
    protected $fillable = [
    	'question_id',
    	'answer_type',
        'answer_value',
        'sample_answer'
    ];
    public $timestamps = false;
}
