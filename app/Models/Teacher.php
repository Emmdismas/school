<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Authenticatable
{
    protected $fillable = [
            'school_id',
            'school_name',
            'teacher_id',
            'full_name', 
            'phone_number', 
            'blood_group', 
            'gender', 
            'date_of_birth',
            'teacher_email', 
            'nida_number',
            'city',
            'district',
            'address',
            'name', 
            'password',
            'subjects', 
            'classes', 
            'is_class_teacher', 
            'class_incharge', 
            'role',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'subjects' => 'array',
        'classes' => 'array',
        'is_class_teacher' => 'boolean',
    ];

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
