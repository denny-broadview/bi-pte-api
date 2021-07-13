<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'parent_user_id',
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'mobile_no',
        'date_of_birth',
        'profile_image',
        'ip_address',
        'latitude',
        'longitude',
        'gender',
        'country_citizen',
        'country_residence',
        'validity',
        'state',
        'state_code',
        'gstin',
        'status',		'token',
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $appends = ['fullname'];

    public function institue()
    {
        return $this->hasOne(Institues::class);
    }

    public function studentDetails()
    {
        return $this->hasOne(StudentDetails::class);
    }

    public function role()
    {
        return $this->belongsTo(Roles::class,'id');
    }

    public function userSubscriptions()
    {
        return $this->hasMany('App\Models\userSubscriptions');
    }

    public function getFullnameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }
}
