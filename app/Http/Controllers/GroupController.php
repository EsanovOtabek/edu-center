<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Subject;
use App\Models\Teacher;

class GroupController extends Controller
{
    public function index()
    {

    }
    public function create()
    {
        $days = Day::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $rooms = Room::all();
        return view("dashboard.groups.create", compact('days', 'subjects', 'teachers', 'rooms'));
    }

    public function store(Request $request)
    {
        // 1. Ma'lumotlarni validatsiya qilish
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'price' => 'required|numeric|min:0',
            'schedule' => 'nullable|array',
            'schedule.*.day_id' => 'required|exists:days,id',
            'schedule.*.room_id' => 'required|exists:rooms,id',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i|after:schedule.*.start_time',
        ]);

        // 2. Guruhni yaratish
        $group = Group::create([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
            'teacher_id' => $validated['teacher_id'],
            'price' => $validated['price'],
        ]);

        // 3. Jadval ma'lumotlarini saqlash (Agar mavjud bo'lsa)
        if (isset($validated['schedule']) && !empty($validated['schedule'])) {
            foreach ($validated['schedule'] as $schedule) {
                $group->schedules()->create([
                    'day_id' => $schedule['day_id'],
                    'room_id' => $schedule['room_id'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                ]);
            }
        }

        // 4. Foydalanuvchini muvaffaqiyatli xabar bilan qaytarish
        return redirect()->route('admin.groups.create')->with('success', 'Guruh muvaffaqiyatli qo\'shildi.');
    }
}
