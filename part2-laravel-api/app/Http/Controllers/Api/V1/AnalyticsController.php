<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BookingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AnalyticsController extends Controller
{
    public function bookings()
    {
        return BookingLog::select('action', DB::raw('COUNT(*) as total'))
            ->groupBy('action')
            ->get();
    }
}
