<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionDesigns extends Model
{
    use HasFactory;
    protected $table = 'question_designs';
    protected $fillable = [
        'section_id',
        'design_name',
        'file_name',
    ];
    public $timestamps = false;

    public function section()
    {
        return $this->belongsTo('App\Models\Sections',"id","section_id");
    }
}
