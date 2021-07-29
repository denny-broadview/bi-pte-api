<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermissions extends Model
{
    use HasFactory;
    protected $table = 'role_has_permissions';
    protected $fillable = [
        'role_id',
        'module_id',
        'slug'
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
    public function module()
    {
        return $this->hasMany(Modules::class,'id','module_id');
    }

    

}
