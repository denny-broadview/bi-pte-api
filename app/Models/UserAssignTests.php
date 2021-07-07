<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssignTests extends Model
{
    use HasFactory;
    protected $table = 'users_assign_tests';
    protected $fillable = [
    	'user_id',
        'mock_test_id',
        'practise_test_id'
    ];
}
