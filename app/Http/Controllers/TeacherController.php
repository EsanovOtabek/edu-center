<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Group;
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
    // O'qituvchining ma'lumotlarini va guruhlarini ko'rsatish
    public function show($id)
    {
        // O'qituvchini guruhlari va ularning talabalar bilan yuklash
        $teacher = Teacher::with(['groups.students'])->findOrFail($id);

        // Guruhlar sonini aniqlash
        $group = $teacher->groups;
        $groupCount = $group->count();

        // Talabalar sonini aniqlash
        $studentCount = $teacher->groups->sum(function ($group) {
            return $group->students->count();
        });

        return view('dashboard.teachers.show', compact('teacher', 'group', 'groupCount', 'studentCount'));
    }


    // O'qituvchiga oylik berish
    public function giveSalary($id)
    {
        $teacher = Teacher::findOrFail($id);

        try {
            // O'qituvchiga oylik berish
            $teacher->giveSalary();

            return redirect()->route('admin.teachers.show', $teacher->id)->with('success', 'Oylik muvaffaqiyatli berildi');
        } catch (\Exception $e) {
            return redirect()->route('admin.teachers.show', $teacher->id)->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    // O'qituvchiga avans berish
    public function giveAdvance(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $amount = $request->input('amount');


        try {
            // Avansni berish
            $teacher->giveAdvance($amount);

            return redirect()->route('admin.teachers.show', $teacher->id)->with('success', 'Avans muvaffaqiyatli berildi');
        } catch (\Exception $e) {
            return redirect()->route('admin.teachers.show', $teacher->id)->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
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
            'password' => 'required|string|min:8',
            'passport_number' => 'required|string|max:20',
            'salary_percentage' => 'required|numeric|min:0|max:100',
            'subjects' => 'array|required', // Ensure that subjects are provided
            'subjects.*' => 'exists:subjects,id', // Validate the subject IDs
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Rasm uchun validatsiya
        ]);

        $login = $request->phone; // phone to login
        $password = $request->password;
        $user = User::create([
            'fio' => $request->fio,
            'login' => $login,
            'password' => Hash::make($password), // Hash the password
            'role' => 'teacher',
        ]);

        // Rasmni yuklash
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public'); // Rasmlar `storage/app/public/teachers` papkasida saqlanadi
        }

        // Create the teacher, linking to the user
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'fio' => $request->fio,
            'phone' => $request->phone,
            'passport_number' => $request->passport_number,
            'salary_percentage' => $request->salary_percentage,
            'balance' => 0,
            'image' => $imagePath, // Rasm yo‘lini saqlaymiz
        ]);

        // Attach selected subjects to the teacher
        $teacher->subjects()->sync($request->subjects);

        // Return success message
        return redirect()->back()->with('success_msg', 'Teacher added successfully.');
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
            'phone' => 'required|string',
            'passport_number' => 'required|string',
            'fio' => 'required|string',
            'salary_percentage' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Rasm validatsiyasi
        ]);

        if (isset($request->password)) {
            $request->validate(['password' => 'required|string|min:8']);
            $password = $request->password;
            $user = User::find($teacher->user_id);
            $user->password = Hash::make($password);
            $user->phone = $request->phone;
            $user->save();
        }

        // Rasmni yangilash
        $imagePath = $teacher->image; // Eski rasm
        if ($request->hasFile('image')) {
            // Eski rasmni o'chirish
            if ($imagePath && file_exists(storage_path('app/public/' . $imagePath))) {
                unlink(storage_path('app/public/' . $imagePath));
            }
            // Yangi rasmni saqlash
            $imagePath = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update([
            'fio' => $request->fio,
            'phone' => $request->phone,
            'passport_number' => $request->passport_number,
            'salary_percentage' => $request->salary_percentage,
            'image' => $imagePath, // Rasm yo‘li yangilanadi
        ]);

        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        return redirect()->back()->with('success_msg', 'O‘qituvchi muvaffaqiyatli yangilandi.');
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
