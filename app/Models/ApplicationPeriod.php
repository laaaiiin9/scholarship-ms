<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationPeriod extends Model
{
    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_OPEN = 'OPEN';
    public const STATUS_CLOSED = 'CLOSED';

    protected $table = 'application_periods';

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

    public function applications()
    {
        return $this->hasMany(Application::class, 'application_period_id');
    }
}
