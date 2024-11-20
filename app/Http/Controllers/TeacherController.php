<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{

    public function index()
    {
        $teachers = Teacher::with('subjects')->get();
        return view('dashboard.teachers.index', compact('teachers'));
    }

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
            'fio' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'passport_number' => 'required|string|max:20',
            'salary_percentage' => 'required|numeric|min:0|max:100',
            'subjects' => 'array|required', // Ensure that subjects are provided
            'subjects.*' => 'exists:subjects,id', // Validate the subject IDs
        ]);

        // Generate login based on FIO (full name), example: first initial + last name
        $fio = explode(' ', $request->fio);
        $login = strtolower($fio[0][0] . $fio[count($fio) - 1]); // first letter + last name

        // Generate a random password (e.g., 12 characters)
        $password = Str::random(12);
// Create the user with generated login and password
        $user = User::create([
            'fio' => $request->fio,
            'login' => $login,
            'password' => Hash::make($password), // Hash the password
            'role' => 'teacher',
        ]);

        // Create the teacher, linking to the user
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'fio' => $request->fio,
            'phone' => $request->phone,
            'passport_number' => $request->passport_number,
            'salary_percentage' => $request->salary_percentage,
            'balance' => 0, // Default balance
        ]);

        // Attach selected subjects to the teacher
        $teacher->subjects()->sync($request->subjects);

        // Return success message
        return redirect()->route('admin.teachers.index')->with('success_msg', 'Teacher added successfully. Login: ' . $login . ', Password: ' . $password);
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
