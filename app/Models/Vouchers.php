<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    use HasFactory;
    protected $table = 'vouchers';
    protected $fillable = [
        'role_id',
        'name',
        'code',
        'discount_percentage',
        'discount_price',
        'valid_till'
    ];
}
