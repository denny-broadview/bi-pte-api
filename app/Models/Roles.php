<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory; 
    protected $table = 'roles';
    protected $fillable = [
    	'role_name',
    	'status'
    ];

    public function permission()
    {
        return $this->hasMany(RoleHasPermissions::class,'role_id');
    }

    
    public function user()
    {
        return $this->hasMany(user::class,'role_id');
    }
}
