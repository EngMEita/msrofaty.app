<?php

namespace App\Http\Controllers\Acp;

use Carbon\Carbon;
use App\Models\Entry;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    public function index(): View
    {
        // Get entries only for the authenticated user
        $entries = auth()->user()->entries()
            ->with(['records'])
            ->latest('date')
            ->paginate(20);

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
    }
}
