<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accountant extends Authenticatable
{
    protected $fillable = [
    'school_id',
            'school_name',
            'accountant_id',
            'full_name', 
            'phone_number', 
            'blood_group', 
            'gender', 
            'date_of_birth',
            'accountant_email', 
            'nida_number',
            'city',
            'district',
            'address',
            'name', 
            'password',
            'role',
    ];

    protected $hidden = ['password'];


    /**
     * Relationship: Teacher belongs to a School.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    /**
     * Accessor: get the school_type from the related School.
     */
public function getSchoolTypeAttribute(): string
{
    if (!$this->relationLoaded('school')) {
        $this->load('school');
    }

    if (!$this->school) {
        throw new \Exception("School relationship not found for teacher ID {$this->id}");
    }

    return $this->school->school_type;
}
}
