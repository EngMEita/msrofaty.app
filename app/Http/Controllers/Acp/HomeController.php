<?php

namespace App\Http\Controllers\Acp;

use Carbon\Carbon;
use App\Models\Entry;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Get entries only for the authenticated user
        $entries = auth()->user()->entries()
            ->with(['records'])
            ->latest('date')
            ->paginate(20);

        return view('acp.dashboard', compact('entries'));
    }

    public function report($year, $month)
    {
        $entries = $this->getEntriesByYearAndMonth($year, $month);

        return view('acp.report', compact('entries', 'year', 'month'));
    }

    /**
     * Get entries for a specific year and month for authenticated user
     */
    private function getEntriesByYearAndMonth($year = null, $month = null)
    {
        return auth()->user()->entries()
            ->whereYear('date', $year ?? Carbon::today()->year)
            ->whereMonth('date', $month ?? Carbon::today()->month)
            ->with(['records'])
            ->orderBy('date', 'DESC')
            ->get();
    }
}
