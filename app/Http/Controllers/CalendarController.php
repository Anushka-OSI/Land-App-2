<?php

namespace App\Http\Controllers;

use App\Models\CalendarEntry;
use App\Support\EventCalendar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/** Month data for the event calendar shown on every page (partials/event-calendar). */
class CalendarController extends Controller
{
    public function month(Request $request): JsonResponse
    {
        $request->validate(['month' => ['required', 'date_format:Y-m']]);

        $month = Carbon::createFromFormat('Y-m-d', $request->month . '-01')->startOfDay();

        // Only a few years either way – the holiday calendar does not go further
        abort_if(abs($month->diffInYears(now()->startOfMonth())) > 5, 404);

        return response()->json([
            'month' => $month->format('Y-m'),
            'entries' => EventCalendar::monthEntries($month),
        ])->header('Cache-Control', 'public, max-age=300');
    }
}
