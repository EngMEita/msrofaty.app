<?php
namespace App\Http\Controllers\Platform;
use App\Http\Controllers\Controller;
use App\Models\Household;
use App\Models\Plan;
use Illuminate\View\View;
class DashboardController extends Controller { public function index(): View { return view('platform.dashboard', ['households' => Household::with(['owner','subscription.plan'])->latest()->paginate(25), 'plans' => Plan::where('active', true)->get()]); } }
