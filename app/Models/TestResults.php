<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResults extends Model
{
    use HasFactory;
    protected $table = 'test_results';
    protected $fillable = [ 
    	'test_id',
    	'user_id',
    	'section_id',
    	'question_type_id',
    	'get_score',
    	'question_id',
        'subject_id'

    ];

    public function test() 
    {
        return  $this->belongsTo('App\Models\Tests', 'test_id');
    }

    public function question_type() 
    {
        return  $this->belongsTo('App\Models\QuestionTypes', 'question_type_id');
    }

    public function question() 
    {
        return  $this->belongsTo('App\Models\Questions', 'question_id');
    }

    public function section() 
    {
        return  $this->belongsTo('App\Models\Sections', 'section_id');
    }

    public function subject() 
    {
        return  $this->belongsTo('App\Models\Subjects', 'subject_id');
    }

    public function user() 
    {
        return  $this->belongsTo('App\Models\User', 'user_id');
    }
}
