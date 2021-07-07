<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institues extends Model
{
    use HasFactory;
    protected $table = 'institues';
    protected $fillable = [
        'user_id',
        'sub_domain',
        'domain',
        'students_allowed',
        'logo',
        'banner_image',
        'show_admin_videos',
        'show_admin_tests',
        'show_admin_files',
        'show_practice_questions',
        'welcome_message',
        'country_phone_code',
        'phone_number',
        'institute_name',
        'white_labelling'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
