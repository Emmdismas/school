<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecordClassB extends Model
{
    use HasFactory;

    protected $table = 'payment_record_class_b';
    protected $fillable = ['student_id', 'student_name', 'payment_type', 'amount', 'receipt_content'];

    public function student()
    {
        return $this->belongsTo(StudentListClassB::class, 'student_id');
    }
}
