<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Group;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        $teacher_cnt = Teacher::count();
        $student_cnt = Student::count();
        $subject_cnt = Subject::count();
        $group_cnt = Group::count();
        $room_cnt = Room::count();

        return view('dashboard.index', compact('teacher_cnt', 'student_cnt', 'subject_cnt', 'group_cnt', 'room_cnt'));
    }

    public function settings()
    {
        return view('dashboard.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255',
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Eski parolni tekshirish
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Eski parol noto\'g\'ri.']);
        }

        // Ma'lumotlarni yangilash
        $user->update([
            'login' => $request->login,
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Sozlamalar muvaffaqiyatli yangilandi!');
    }


}
