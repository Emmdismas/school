<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'name', 'class', 'blood_group', 'email', 'phone', 'photo'];

    // ✅ Set Dynamic Table Name
    public function getTable()
    {
        return isset($this->attributes['class'])
            ? 'student_list_' . strtolower($this->attributes['class'])
            : parent::getTable();
    }

    // ✅ Relationships
    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'student_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'student_id');
    }

    public function homework()
    {
        return $this->hasMany(Homework::class, 'student_id');
    }

    public function homepackage()
    {
        return $this->hasMany(Homepackage::class, 'student_id');
    }

    public function writtenTests()
    {
        return $this->hasMany(WrittenTest::class, 'student_id');
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class, 'student_id');
    }
     // Uhusiano na meza ya schools
     public function school()
     {
         return $this->belongsTo(School::class, 'school_id');
     }
}
