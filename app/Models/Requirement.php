<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public const TYPE_APPLICATION = 'APPLICATION';
    public const TYPE_RENEWAL = 'RENEWAL';

    protected $table = 'requirements';

    protected $fillable = [
        'scholarship_id',
        'name',
        'type'
    ];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }

    public function applicationDocuments()
    {
        return $this->hasMany(ApplicationDocument::class, 'requirement_id');
    }
}
