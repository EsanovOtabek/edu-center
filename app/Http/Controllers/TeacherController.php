<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('subjects')->get();
        return view('dashboard.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('dashboard.teachers.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|string',
            'passport_number' => 'required|string',
            'full_name' => 'required|string',
            'salary_percentage' => 'required|numeric',
            'balance' => 'required|numeric'
        ]);

        $teacher = Teacher::create($request->all());

        // Tanlangan fanlarni bog'lash
        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        return redirect()->route('admin.teachers.index')->with('success_msg', 'O‘qituvchi muvaffaqiyatli yaratildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        dd($teacher);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('dashboard.teachers.edit', compact('teacher', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|string',
            'passport_number' => 'required|string',
            'full_name' => 'required|string',
            'salary_percentage' => 'required|numeric',
            'balance' => 'required|numeric'
        ]);

        $teacher->update($request->all());


        // Tanlangan fanlarni yangilash
        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        return redirect()->route('admin.teachers.index')->with('success_msg', 'O‘qituvchi muvaffaqiyatli yangilandi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete(); // Soft delete
        return redirect()->route('admin.teachers.index')->with('success_msg', 'O‘qituvchi muvaffaqiyatli arxivlandi.');
    }
}
