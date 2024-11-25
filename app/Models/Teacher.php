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

    // O'qituvchiga tegishli dividendlarni olish
    public function dividends()
    {
        return $this->hasMany(Dividend::class);
    }
    // O'qituvchiga oylik (salary) yoki avans berish
    public function giveSalary()
    {
        // Oylik miqdorini hisoblash
        $salaryAmount = $this->balance * ($this->salary_percentage / 100);

        // Dividentlar jadvaliga yozish
        Dividend::create([
            'teacher_id' => $this->id,
            'amount' => $salaryAmount,
            'type' => 'salary', // Oylik turi
        ]);

        // O'qituvchining balansini yangilash
        $this->balance -= $salaryAmount;
        $this->save();
    }

    // O'qituvchiga avans berish
    public function giveAdvance($amount)
    {
        if ($amount > $this->balance) {
            throw new \Exception('Balansda yetarli mablag\' yo\'q');
        }

        // Avansni dividentlar jadvaliga yozish
        Dividend::create([
            'teacher_id' => $this->id,
            'amount' => $amount,
            'type' => 'advance', // Avans turi
        ]);

        // O'qituvchining balansidan avansni ayrish
        $this->balance -= $amount;
        $this->save();
    }

    public function addToBalance($amount)
    {
        $this->balance += $amount;
        $this->save();
    }




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
