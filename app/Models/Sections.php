<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $fillable = [
    	'section_name',
    	'image'
    ];
    public function question(){
        return $this->hasMany('App\Models\Questions','section_id','id')->with(['questiondata','question_type']);
    }
	public function taskResult(){
        return $this->hasMany('App\Models\TestResults','section_id','id');    
    }
    
}
