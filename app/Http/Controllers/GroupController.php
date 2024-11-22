<?php

namespace App\Http\Controllers;

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
        return view("dashboard.groups.create", compact('days', 'subjects', 'teachers'));
    }
}
