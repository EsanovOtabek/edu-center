<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('groups');

        $group_id = 0;
        if ($request->has('group_id') && $request->isMethod('get')) {
            $group_id = intval($request->input('group_id'));
        }

        if ($group_id > 0) {
            $query->whereHas('groups', function ($q) use ($request) {
                $q->where('groups.id', $request->group_id);
            });
        }
        $students = $query->get(); // Talabalar va guruhlarni yuklash


        $groups = Group::all(); // Filtr uchun barcha guruhlar
        return view('dashboard.students.index', compact('students', 'groups', 'group_id'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('dashboard.students.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fio' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'father_fio' => 'nullable|string|max:255',
            'mother_fio' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:15',
            'mother_phone' => 'nullable|string|max:15',
            'telegram_id' => 'nullable|string|max:255',
            'groups' => 'nullable|array',
            'groups.*.id' => 'required|exists:groups,id',
            'groups.*.start_date' => 'required|date',
        ]);

        $student = Student::create($validated);

        if (!empty($validated['groups'])) {
            foreach ($validated['groups'] as $group) {
                $student->groups()->attach($group['id'], ['start_date' => $group['start_date']]);
            }
        }

        return redirect()->back()->with('success_msg', 'O‘quvchi muvaffaqiyatli qo‘shildi.');
    }

    public function edit(Student $student)
    {
        $groups = Group::all();
        return view('dashboard.students.edit', compact('groups', 'student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'fio' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'telegram_id' => 'nullable|string|max:255',
        ]);

        $student->update($request->only([
            'fio',
            'phone',
            'address',
            'telegram_id',
            'father_fio',
            'mother_fio',
            'father_phone',
            'mother_phone'
        ]));

        // Guruhlarni yangilash
        $student->groups()->detach();
        foreach ($request->groups as $group) {
            $student->groups()->attach($group['id'], ['start_date' => $group['start_date']]);
        }

        return redirect()->back()->with('success', 'O‘quvchi muvaffaqiyatli yangilandi.');
    }


}
