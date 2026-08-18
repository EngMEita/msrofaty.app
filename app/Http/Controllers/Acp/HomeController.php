<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $household = auth()->user()->household();
        $entries = $household ? $household->entries()
            ->with(['records'])
            ->latest('date')
            ->paginate(20) : collect();

        return view('acp.dashboard', compact('entries'));
    }

    public function report(int $year, int $month): View
    {
        $entries = $this->getEntriesByYearAndMonth($year, $month);

        return view('acp.report', compact('entries', 'year', 'month'));
    }

    /**
     * Get entries for a specific year and month for authenticated user
     */
    private function getEntriesByYearAndMonth(?int $year = null, ?int $month = null)
    {
        $household = auth()->user()->household();

        if (!$household) {
            return collect();
        }

        return $household->entries()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with('records')
            ->latest('date')
            ->get();
    }
}
