<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Davomat formasi
    public function index(Request $request, Group $group)
    {
        $currentYear = $request->get('year', now()->year);
        $currentMonth = $request->get('month', now()->month);
        $today = Carbon::today()->format(format: 'd');


        // Hozirgi sana va vaqt
        $currentDateTime = Carbon::now()->setTimezone(value: 'Asia/Tashkent');

        // Guruhning darslari jadvali
        $schedules = $group->schedules;

        $lessonInProgress = false;
        if ($currentYear == now()->year && $currentMonth == now()->month) {
            foreach ($schedules as $schedule) {
                $startTime = Carbon::parse($schedule->start_time);  // Dars boshlanish vaqti
                $endTime = Carbon::parse($schedule->end_time);      // Dars tugash vaqti
                $scheduleDay = $schedule->day->name_en; // Dars bo'ladigan kun

                $startTimeFormatted = $startTime->format('H:i');  // Extract hours and minutes
                $currentTimeFormatted = $currentDateTime->format('H:i');  // Extract hours and minutes
                $endTimeFormatted = $endTime->format('H:i');  // Extract hours and minutes

                // print ($currentDateTime);
                // print ("<br>");

                // print ($startTime) . "|";
                // print ($currentDateTime->greaterThanOrEqualTo(date: $startTime));
                // print ("<br>");

                // print ($endTimeFormatted) . "|";
                // print ($currentDateTime->lessThanOrEqualTo($endTime->endOfDay()));
                // print (strtolower($scheduleDay) == strtolower($currentDateTime->englishDayOfWeek));
                // print ("<hr>");
                if (
                    $currentTimeFormatted >= $startTimeFormatted &&
                    $currentTimeFormatted <= "23:59" &&
                    strtolower($scheduleDay) == strtolower($currentDateTime->englishDayOfWeek)
                ) {

                    $lessonInProgress = true;
                    break;
                }
            }

        }

        $years = range(now()->year - 3, now()->year + 3);
        $months = [
            ['number' => 1, 'name' => 'Yanvar'],
            ['number' => 2, 'name' => 'Fevral'],
            ['number' => 3, 'name' => 'Mart'],
            ['number' => 4, 'name' => 'Aprel'],
            ['number' => 5, 'name' => 'May'],
            ['number' => 6, 'name' => 'Iyun'],
            ['number' => 7, 'name' => 'Iyul'],
            ['number' => 8, 'name' => 'Avgust'],
            ['number' => 9, 'name' => 'Sentabr'],
            ['number' => 10, 'name' => 'Oktabr'],
            ['number' => 11, 'name' => 'Noyabr'],
            ['number' => 12, 'name' => 'Dekabr'],
        ];

        $daysInMonth = collect(range(1, Carbon::parse("$currentYear-$currentMonth-01")->daysInMonth))
            ->filter(function ($day) use ($currentYear, $currentMonth, $group) {
                $dayOfWeek = Carbon::parse("$currentYear-$currentMonth-$day")->englishDayOfWeek;
                return in_array($dayOfWeek, $group->schedules->pluck('day.name_en')->toArray());
            });

        $students = $group->students;
        $attendanceData = Attendance::whereYear('attendance_date', $currentYear)
            ->whereMonth('attendance_date', $currentMonth)
            ->where('group_id', $group->id)
            ->get()
            ->groupBy(['student_id', 'attendance_date']);

        return view('dashboard.davomat.index', compact('group', 'years', 'months', 'daysInMonth', 'students', 'attendanceData', 'currentYear', 'currentMonth', 'today', 'lessonInProgress'));
    }


    public function saveAttendance(Request $request, Group $group)
    {
        $attendanceData = $request->validate([
            'status' => 'required|array',
        ]);

        // Hozirgi sanani olish
        $now = now(); // Bugungi sana (saat 00:00)

        foreach ($request->status as $studentId => $status) {
            $attendanceDate = $now->format('Y-m-d');
            if (is_null($status))
                continue;

            if (!in_array($now->englishDayOfWeek, $group->schedules->pluck('day.name_en')->toArray())) {
                return back()->withErrors(['error' => 'Bugun guruhning darsi mavjud emas.']);
            }


            Attendance::updateOrCreate(
                [
                    'group_id' => $group->id,
                    'student_id' => $studentId,
                    'attendance_date' => $attendanceDate,
                ],
                [
                    'status' => $status,
                    'marked_by_teacher' => auth()->user()->role == 'teacher',
                ]
            );
        }

        return redirect()->back()->with('success_msg', "Davomat qilindi!");
    }

}
