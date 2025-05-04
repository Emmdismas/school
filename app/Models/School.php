<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools'; // Hakikisha jina la jedwali lipo sahihi


        protected $fillable = [
            'school_name',
            'school_id',
            'region',
            'district',
            'school_type',
            'school_fee',
            'grades',
            'number_of_students',
            'number_of_teachers',
        ];
        

        protected $casts = [
            'grades' => 'array',
        ];
        
    // Relationship with students
    public function students(): HasMany
    {
        return $this->hasMany(Students::class, 'school_id', 'school_id');
    }

    // Relationship with teachers
    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, 'school_id', 'school_id');
    }

    // Method to get the number of students
    public function getNumberOfStudentsAttribute(): int
    {
        return $this->students()->count();
    }

    // Method to get the number of teachers
    public function getNumberOfTeachersAttribute(): int
    {
        return $this->teachers()->count();
    }
}
