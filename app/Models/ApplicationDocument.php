<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_VALID = 'VALID';
    public const STATUS_INVALID = 'INVALID';
    
    public const TYPE_APPLICATION = 'APPLICATION';
    public const TYPE_RENEWAL = 'RENEWAL';

    protected $table = 'application_documents';

    protected $fillable = [
        'application_id',
        'requirement_id',
        'renewal_id',
        'file_path',
        'verification_status',
        'type'
    ];

    public function renewal()
    {
        return $this->belongsTo(Renewal::class, 'renewal_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }
}
