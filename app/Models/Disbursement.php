<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_RELEASED = 'RELEASED';
    public const STATUS_PAID = 'PAID';

    protected $fillable = [
        'application_id',
        'renewal_id',
        'amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function renewal()
    {
        return $this->belongsTo(Renewal::class, 'renewal_id');
    }
}
