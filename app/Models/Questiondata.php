<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questiondata extends Model
{
    use HasFactory;
    protected $table = 'question_data';
    protected $fillable = [
    	'question_id',
    	'data_type',
        'data_value'
    ];
    public $timestamps = false;
}
