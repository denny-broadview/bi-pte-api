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
        return $this->hasOne('App\Models\Questions','id','section_id');
    }
	public function taskResult()    {        return $this->hasMany('App\Models\TestResults','section_id','id');    }
    
}
