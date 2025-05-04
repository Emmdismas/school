<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecords extends Model
{
    use HasFactory;

    protected $table = 'payment_records'; // Jina la jedwali
    protected $fillable = [
        'school_id',
        'student_id',
         'academic_year',
        'student_name', 
        'class',
        'payment_type',
        'amount',
        'receipt_content',
        'receipt_filename',
        ];

    
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
