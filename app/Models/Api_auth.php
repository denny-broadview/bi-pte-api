<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Api_auth extends Model implements Authenticatable
{   
   use AuthenticableTrait;
   protected $table = 'api_token';

   // protected $fillable = ['user_id','token','user_type'];
   protected $fillable = ['user_id','token'];

   protected $hidden = [
   ];
}