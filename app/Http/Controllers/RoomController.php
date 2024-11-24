<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('dashboard.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        // Xonaga bog'liq jadvalni olish (7 kun bo'yicha)
        $schedule = $room->schedules()
            ->with(['day', 'group.subject', 'group.teacher'])
            ->get()
            ->groupBy('day.name'); // Kunlar bo'yicha guruhlash

        return view('dashboard.schedules.by-rooms', compact('room', 'schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'capacity' => 'nullable|integer|min:0',
        ]);

        Room::create($request->all());

        return redirect()->back()->with('success_msg', 'Xona muvaffaqiyatli qo\'shildi!');
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'capacity' => 'nullable|integer|min:0',
        ]);

        $room->update($request->all());

        return redirect()->back()->with('success_msg', 'Xona muvaffaqiyatli yangilandi!');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success_msg', 'Xona muvaffaqiyatli o\'chirildi!');
    }
}
