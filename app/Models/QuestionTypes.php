<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTypes extends Model
{
    use HasFactory;
    protected $table = 'question_types';
    protected $fillable = [
        'section_id',
        'desgin_id',
        'question_title',
        'min_question',
        'max_question',
        'score',
        'instructions'
    ];
    public $timestamps = false;
}
