<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecordClassA extends Model
{
    use HasFactory;

    protected $table = 'payment_record_class_a'; // Jina la jedwali
    protected $fillable = ['student_id','student_name', 'payment_type', 'amount', 'receipt_content'];

    // Relationship na wanafunzi
    public function student()
    {
        return $this->belongsTo(StudentListClassA::class, 'student_id');
    }
}
