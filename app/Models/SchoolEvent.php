<?php

// app/Models/SchoolEvent.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    protected $fillable = [
        'school_id',
        'user_id',
        'event_type',
        'title',
        'description',
        'event_date',
        'school_type',
    ];


     // Mhusika aliyepakia tukio
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
 // Relationship na wanafunzi
    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'student_id');
    }    
     // Uhusiano na meza ya schools
     public function school()
     {
         return $this->belongsTo(School::class, 'school_id');
     }
}
