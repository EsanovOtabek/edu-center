<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('groups')->get();
        return view('dashboard.students.index', compact('students'));
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

        return redirect()->route('students.index')->with('success', 'O‘quvchi muvaffaqiyatli qo‘shildi.');
    }

}
