<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_SUBMITTED = 'SUBMITTED';
    public const STATUS_UNDER_REVIEW = 'UNDER_REVIEW';
    public const STATUS_REVISION_REQUIRED = 'REVISION_REQUIRED';
    public const STATUS_DECIDED = 'DECIDED';

    protected $table = 'applications';

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'application_period_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }

    public function applicationPeriod()
    {
        return $this->belongsTo(ApplicationPeriod::class, 'application_period_id');
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id')
            ->where('type', ApplicationDocument::TYPE_APPLICATION);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'application_id');
    }

    public function decision()
    {
        return $this->hasOne(Decision::class, 'application_id');
    }

    public function renewals()
    {
        return $this->hasMany(Renewal::class, 'application_id');
    }

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class, 'application_id');
    }
}
