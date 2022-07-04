<?php

namespace App\Http\Controllers\Acp;

use Carbon\Carbon;
use App\Models\Entry;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // $entries = $this->getEntriesByYearAndMonth ();
        $entries = Entry::all();
        return view('acp.dashboard', compact('entries'));
    }

    public function report($year, $month)
    {
        $entries = $this->getEntriesByYearAndMonth ($year, $month);
        dd ($entries) ;
    }




    // The repeated methods //
    private function getEntriesByYearAndMonth ($year = null, $month = null)
    {
        return Entry::whereYear('date', $year ?? Carbon::today()->year)
                    ->whereMonth('date', $month ?? Carbon::today()->month)
                    ->with(['records'])
                    ->orderBy('date', 'DESC')
                    ->get();
    }
}
