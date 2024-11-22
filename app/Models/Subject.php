<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // O'qituvchilar bilan ko'pdan-ko'p bog'lanish
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }


}
