<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingLog;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'booking_date' => 'required|date',
        ]);

        $booking = Booking::create($data);

        BookingLog::create([
            'booking_id' => $booking->id,
            'action' => 'created',
        ]);

        return response()->json($booking, 201);
    }

    public function show($id)
    {
        return Booking::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        BookingLog::create([
            'booking_id' => $id,
            'action' => 'updated',
        ]);

        return $booking;
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();

        BookingLog::create([
            'booking_id' => $id,
            'action' => 'deleted',
        ]);

        return response()->json(['message' => 'Booking cancelled']);
    }
}
