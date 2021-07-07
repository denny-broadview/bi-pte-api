<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;
    protected $table = 'test_subjects';
    protected $fillable = [
    	'subject_name',
    	'status'
    ];

    // public function tests()
    // {
    //     return $this->hasOne('App\Models\Tests', 'subject_id');
    // }
}
