<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Student;


class School extends Model
{
    
    use HasFactory;

    protected $table = 'schools';

    
    protected $primaryKey = 'school_id';
    public $incrementing = false;
    protected $keyType = 'int'; // au 'int' kama `school_id` ni number


    protected $fillable = [
        'school_name',
        'school_id',
        'region',
        'district',
        'school_type',
        'fees_structure', // I added this based on your controller
        'grades',
        'subjects',
        'number_of_students',
        'number_of_teachers',
    ];

    protected $casts = [
        'fees_structure' => 'array',
        'grades' => 'array',
        'subjects' => 'array',
    ];


    
    
    // Relationship with students
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'school_id', 'school_id');
    }

    // Relationship with teachers
    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, 'school_id', 'school_id');
    }

    // Method to get the number of students
    public function getNumberOfStudentsAttribute(): int
    {
        return $this->number_of_students ?? $this->students()->count();
    }

    // Method to get the number of teachers
    public function getNumberOfTeachersAttribute(): int
    {
        return $this->number_of_teachers ?? $this->teachers()->count();
    }

    // Method to get subjects by class/standard
    public function getSubjectsByClass($class)
    {
        $subjects = $this->subjects ?? [];
        return $subjects[$class] ?? [];
    }

    // New method to get combinations for advanced level
    public function getCombinations()
    {
        if ($this->school_type !== 'advance') {
            return [];
        }

        return $this->subjects['combinations'] ?? [];
    }

    // New method to get fees for specific class
    public function getFeesForClass($class)
    {
        return $this->fees_structure[$class] ?? null;
    }
    // app/Models/School.php

public function newEloquentBuilder($query)
{
    return new class($query) extends Builder {
        public function whereKey($id)
        {
            $keyName = $this->model->getQualifiedKeyName();
            if (str_contains($keyName, 'id')) {
                $keyName = str_replace('id', 'school_id', $keyName);
            }
            return $this->where($keyName, '=', $id);
        }
    };
}
}