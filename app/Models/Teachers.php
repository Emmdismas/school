<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teachers extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'teachers';
    protected $fillable = ['school_id', 'name', 'password', 'role'];
    protected $hidden = ['password'];
    public $timestamps = false;

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    // Event listener kwa kuongeza au kupunguza idadi ya walimu
    protected static function boot()
    {
        parent::boot();

        static::created(function ($teacher) {
            // Ongeza idadi ya walimu kwa school_id husika
            $teacher->school->increment('number_of_teachers');
        });

        static::deleted(function ($teacher) {
            // Punguza idadi ya walimu ikiwa imefutwa
            $teacher->school->decrement('number_of_teachers');
        });
    }
}
