<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fio',
        'phone',
        'address',
        'father_fio',
        'mother_fio',
        'father_phone',
        'mother_phone',
        'telegram_id',
    ];


    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_student')
            ->withPivot('start_date')
            ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
