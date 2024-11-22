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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'capacity' => 'nullable|integer|min:0',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success_msg', 'Xona muvaffaqiyatli qo\'shildi!');
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'capacity' => 'nullable|integer|min:0',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success_msg', 'Xona muvaffaqiyatli yangilandi!');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success_msg', 'Xona muvaffaqiyatli o\'chirildi!');
    }
}
