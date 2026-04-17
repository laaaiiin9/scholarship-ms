<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenewalPeriod extends Model
{
    protected $table = 'renewal_periods';

    protected $fillable = [
        'scholarship_id',
        'start_date',
        'end_date',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }

    public function renewals()
    {
        return $this->hasMany(Renewal::class, 'renewal_period_id');
    }
}
