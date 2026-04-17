<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    public const RESULT_APPROVED = 'APPROVED';
    public const RESULT_REJECTED = 'REJECTED';
    public const RESULT_WAITLISTED = 'WAITLISTED';

    protected $fillable = [
        'application_id',
        'decided_by',
        'result'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function decider()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
