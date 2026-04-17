<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    public const STATUS_SUBMITTED = 'SUBMITTED';
    public const STATUS_UNDER_REVIEW = 'UNDER_REVIEW';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';

    protected $fillable = [
        'application_id',
        'renewal_period_id',
        'user_id',
        'status',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function renewalPeriod()
    {
        return $this->belongsTo(RenewalPeriod::class, 'renewal_period_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class, 'renewal_id');
    }
}
