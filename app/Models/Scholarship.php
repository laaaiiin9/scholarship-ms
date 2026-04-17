<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{

    use HasFactory;

    protected $table = "scholarships";

    protected $fillable = [
        'name',
        'description',
        'max_amount',
        'created_by'
    ];

    public function applicationPeriods()
    {
        return $this->hasMany(ApplicationPeriod::class, 'scholarship_id');
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'scholarship_id');
    }

    public function renewalPeriods()
    {
        return $this->hasMany(RenewalPeriod::class, 'scholarship_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'scholarship_id');
    }

    public function renewals()
    {
        return $this->hasManyThrough(
            Renewal::class,
            Application::class,
            'scholarship_id',
            'application_id',
            'id',
            'id'
        );
    }
}
