<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{

    use HasFactory, SoftDeletes; // SoftDeletes traitini ulash

    protected $fillable = [
        'user_id',
        'phone',
        'passport_number',
        'fio',
        'salary_percentage',
        'balance',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }


}
