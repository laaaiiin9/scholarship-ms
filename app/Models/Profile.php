<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "user_profile";

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'contact_number',
        'address',
        'birth_date',
        'gender',
        'school',
        'course',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
