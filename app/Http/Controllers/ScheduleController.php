<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Group;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    public function index()
    {
        // Barcha guruhlar, ularning jadvalini va kerakli boshqa ma'lumotlarni olish
        $groups = Group::with(['subject', 'teacher', 'schedules.room', 'schedules.day'])
            ->get();

        // Barcha kunlar va xonalar
        $days = Day::all();
        $rooms = Room::all();

        return view('dashboard.schedules.index', compact('groups', 'days', 'rooms'));
    }

    public function checkScheduleStart(Request $request)
    {
        $response = "<option selected disabled value=\"\">Boshlash</option>";

        $day_id = $request->day_id;
        $room_id = $request->room_id;

        $intervals = $this->getTimeIntervals();

        foreach ($intervals as $key => $interval) {
            $h1 = $interval[0];
            $h2 = $interval[1];

            // 'start_time' va 'end_time' orasidagi intervalni tekshirish
            $checkSchedule = Schedule::where('day_id', $day_id)
                ->where('room_id', $room_id)
                ->where(function($query) use ($h1, $h2) {
                    // Intervalga to'g'ri keladigan yozuvlar mavjudligini tekshirish
                    $query->where('start_time', '<', $h2)
                        ->where('end_time', '>', $h1);
                })
                ->exists(); // Agar ma'lumot bo'lsa, true qaytaradi

            if ($checkSchedule) {
                $response .= "<option value='' disabled>" . $h1 . "</option>";
            }else{
                $response .= "<option value='".$h1."'>" . $h1 . "</option>";
            }

        }

        return $response;
    }


    public function checkScheduleEnd(Request $request)
    {

    }
    public function checkSchedule($dayId, $roomId, $startTime, $endTime)
    {
        // Convert startTime and endTime to time format
        $startTime = \Carbon\Carbon::parse($startTime);
        $endTime = \Carbon\Carbon::parse($endTime);

        // Find schedules that conflict with the selected time slot
        $bookedSchedules = Schedule::where('day_id', $dayId)
            ->where('room_id', $roomId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                    });
            })
            ->get();

        // Return the booked times (start times) to disable
        $bookedTimes = $bookedSchedules->pluck('start_time')->toArray();

        return response()->json([
            'bookedTimes' => $bookedTimes,
        ]);
    }

    public function getTimeIntervals()
    {
        $intervals = [
            ['00:00', '00:30'],
            ['00:30', '01:00'],
            ['01:00', '01:30'],
            ['01:30', '02:00'],
            ['02:00', '02:30'],
            ['02:30', '03:00'],
            ['03:00', '03:30'],
            ['03:30', '04:00'],
            ['04:00', '04:30'],
            ['04:30', '05:00'],
            ['05:00', '05:30'],
            ['05:30', '06:00'],
            ['06:00', '06:30'],
            ['06:30', '07:00'],
            ['07:00', '07:30'],
            ['07:30', '08:00'],
            ['08:00', '08:30'],
            ['08:30', '09:00'],
            ['09:00', '09:30'],
            ['09:30', '10:00'],
            ['10:00', '10:30'],
            ['10:30', '11:00'],
            ['11:00', '11:30'],
            ['11:30', '12:00'],
            ['12:00', '12:30'],
            ['12:30', '13:00'],
            ['13:00', '13:30'],
            ['13:30', '14:00'],
            ['14:00', '14:30'],
            ['14:30', '15:00'],
            ['15:00', '15:30'],
            ['15:30', '16:00'],
            ['16:00', '16:30'],
            ['16:30', '17:00'],
            ['17:00', '17:30'],
            ['17:30', '18:00'],
            ['18:00', '18:30'],
            ['18:30', '19:00'],
            ['19:00', '19:30'],
            ['19:30', '20:00'],
            ['20:00', '20:30'],
            ['20:30', '21:00'],
            ['21:00', '21:30'],
            ['21:30', '22:00'],
            ['22:00', '22:30'],
            ['22:30', '23:00'],
            ['23:00', '23:30'],
            ['23:30', '00:00']
        ];

        return $intervals;
    }

}
