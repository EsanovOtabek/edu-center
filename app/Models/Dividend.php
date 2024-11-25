<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'type',
        'amount',
        'date',
    ];

    // O'qituvchiga bog'lanish
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
