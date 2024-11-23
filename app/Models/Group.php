<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes; // SoftDeletes traitini ulash

    protected $fillable = [
        'name',
        'subject_id',
        'teacher_id',
        'status',
        'price',
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_student')
            ->withPivot('start_date')
            ->withTimestamps();
    }



}
