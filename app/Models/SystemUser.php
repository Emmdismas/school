<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SystemUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'system_users';

    // Safu zinazoruhusiwa kujazwa kwa mass assignment
    protected $fillable = ['school_name', 'school_id', 'role', 'name', 'password'];

    // Safu zinazofichwa wakati wa kutoa data (kwa mfano, API call)
    protected $hidden = ['password'];

    // Ikiwa hakuna haja ya kufuatilia timestamps
    public $timestamps = false;

    // Uhusiano na meza ya schools
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id'); // 'school_id' ni primary key ya schools
    }

    // Accessor ya school_type (optional)
public function getSchoolTypeAttribute()
{
    return $this->school->school_type;
}
}
