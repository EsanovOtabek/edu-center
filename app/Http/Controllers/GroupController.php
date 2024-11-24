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
        $groups = Group::with(['subject', 'teacher'])->orderBy('status', "ASC")->get(); // Fanni va o'qituvchini aloqalar orqali olish
        return view('dashboard.groups.index', compact('groups'));
    }

    public function show($id)
    {
        // Guruhni va unga tegishli talabalarni yuklash
        $group = Group::with('students')->findOrFail($id);

        return view('dashboard.groups.show', compact('group'));
    }


    public function create()
    {
        $days = Day::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $rooms = Room::all();
        return view("dashboard.groups.create", compact('days', 'subjects', 'teachers', 'rooms'));
    }

    public function edit(Group $group)
    {
        $days = Day::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $rooms = Room::all();
        return view("dashboard.groups.edit", compact('days', 'subjects', 'teachers', 'rooms', 'group'));
    }

    public function store(Request $request)
    {
        // 1. Ma'lumotlarni validatsiya qilish
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'price' => 'required|numeric|min:0',
            'schedule' => 'nullable|array',
            'schedule.*.day_id' => 'required|exists:days,id',
            'schedule.*.room_id' => 'required|exists:rooms,id',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i|after:schedule.*.start_time',
        ]);

        // 2. Vaqt oralig'ini tekshirish
        foreach ($validated['schedule'] as $schedule) {
            $conflictingSchedule = \DB::table('schedules')
                ->where('room_id', $schedule['room_id'])
                ->where('day_id', $schedule['day_id'])
                ->where(function ($query) use ($schedule) {
                    $query->whereBetween('start_time', [$schedule['start_time'], $schedule['end_time']])
                        ->orWhereBetween('end_time', [$schedule['start_time'], $schedule['end_time']])
                        ->orWhereRaw('? BETWEEN start_time AND end_time', [$schedule['start_time']])
                        ->orWhereRaw('? BETWEEN start_time AND end_time', [$schedule['end_time']]);
                })
                ->exists();

            if ($conflictingSchedule) {
                return back()->withErrors(['schedule' => 'Jadvaldagi vaqt oralig\'i band qilingan.']);
            }
        }

        // 3. Guruhni yaratish
        $group = Group::create([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
            'teacher_id' => $validated['teacher_id'],
            'price' => $validated['price'],
        ]);

        // 4. Jadvalni saqlash
        if (!empty($validated['schedule'])) {
            foreach ($validated['schedule'] as $schedule) {
                $group->schedules()->create([
                    'day_id' => $schedule['day_id'],
                    'room_id' => $schedule['room_id'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                ]);
            }
        }

        // 5. Muvaffaqiyatli xabar bilan qaytarish
        return redirect()->back()->with('success', 'Guruh muvaffaqiyatli qo\'shildi.');
    }


    public function update(Request $request, Group $group)
    {
        // 1. Ma'lumotlarni validatsiya qilish
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'price' => 'required|numeric|min:0',
            'schedule' => 'nullable|array',
            'schedule.*.day_id' => 'required|exists:days,id',
            'schedule.*.room_id' => 'required|exists:rooms,id',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i|after:schedule.*.start_time',
        ]);

        // 2. Vaqt oralig'ini tekshirish
        foreach ($validated['schedule'] as $schedule) {
            $conflictingSchedule = \DB::table('schedules')
                ->where('room_id', $schedule['room_id'])
                ->where('day_id', $schedule['day_id'])
                ->where('group_id', '!=', $group->id) // Hozirgi guruh jadvalidan tashqari
                ->where(function ($query) use ($schedule) {
                    $query->whereBetween('start_time', [$schedule['start_time'], $schedule['end_time']])
                        ->orWhereBetween('end_time', [$schedule['start_time'], $schedule['end_time']])
                        ->orWhereRaw('? BETWEEN start_time AND end_time', [$schedule['start_time']])
                        ->orWhereRaw('? BETWEEN start_time AND end_time', [$schedule['end_time']]);
                })
                ->exists();

            if ($conflictingSchedule) {
                return back()->withErrors(['schedule' => 'Jadvaldagi vaqt oralig\'i band qilingan.']);
            }
        }

        // 3. Guruhni yangilash
        $group->update([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
            'teacher_id' => $validated['teacher_id'],
            'price' => $validated['price'],
        ]);

        // 4. Jadvalni yangilash
        $group->schedules()->delete();
        if (!empty($validated['schedule'])) {
            foreach ($validated['schedule'] as $schedule) {
                $group->schedules()->create([
                    'day_id' => $schedule['day_id'],
                    'room_id' => $schedule['room_id'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                ]);
            }
        }

        // 5. Muvaffaqiyatli xabar bilan qaytarish
        return redirect()->back()->with('success', 'Guruh muvaffaqiyatli yangilandi.');
    }



    public function destroy(Group $group)
    {
        $group->delete(); // Soft delete
        return redirect()->route('admin.groups.index')->with('success_msg', 'Guruh muvaffaqiyatli arxivlandi.');
    }

}
