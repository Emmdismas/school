<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';

    protected $primaryKey = 'student_id';

    public $incrementing = false; 
    
    protected $fillable = [
        'student_id',
        'school_id',
        'class',
        'student_name',
        'gender',
        'date_of_birth',
        'blood_group',
        'parent_name',
        'parent_number',
        'parent_email',
        'relationship',
        'photo',
        'year_of_study', // ✅ Hii lazima iwe hapa
        'status',
    ];
    
    /**
     * Scope query kwa darasa maalum
     */
    public function scopeForClass($query, $class)
    {
        return $query->where('class', $class);
    }
    
    /**
     * Uhusiano na school
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}