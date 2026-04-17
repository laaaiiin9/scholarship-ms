<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'application_id',
        'reviewed_by',
        'remarks'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
