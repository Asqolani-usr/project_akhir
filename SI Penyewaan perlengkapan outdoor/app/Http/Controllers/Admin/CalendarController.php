<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gear;
use App\Models\Transaction;

class CalendarController extends Controller
{
    public function index()
    {
        $gears = Gear::all();
        $transactions = Transaction::whereIn('status', Transaction::ACTIVE_STATUSES)
            ->with('items')
            ->get();

        $events = [];
        foreach ($transactions as $t) {
            foreach ($t->items as $item) {
                $events[] = [
                    'title' => $item->gear_name . ' (' . $t->customer_name . ')',
                    'start' => $t->rental_start->format('Y-m-d'),
                    'end' => $t->rental_end->format('Y-m-d'),
                    'status' => $t->status,
                    'code' => $t->code,
                ];
            }
        }

        return view('admin.calendar', compact('gears', 'events'));
    }
}
