<?php
namespace App\Http\Controllers\Platform;
use App\Http\Controllers\Controller;
use App\Models\Household;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HouseholdController extends Controller {
 public function store(Request $request) { $data=$request->validate(['name'=>'required|string|max:150','owner_name'=>'required|string|max:255','owner_email'=>'required|email|unique:users,email','plan_id'=>'required|exists:plans,id']); return DB::transaction(function() use($data) { $user=User::create(['name'=>$data['owner_name'],'email'=>$data['owner_email'],'password'=>bcrypt(str()->random(32))]); $household=Household::create(['name'=>$data['name'],'owner_id'=>$user->id]); $household->users()->attach($user,['role'=>'owner']); Subscription::create(['household_id'=>$household->id,'plan_id'=>$data['plan_id'],'status'=>'active','starts_at'=>now()]); return redirect()->route('platform.dashboard')->with('message','Household created.'); }); }
 public function updateStatus(Request $request, Household $household) { $data=$request->validate(['status'=>'required|in:active,suspended']); $household->update($data); return back()->with('message','Household status updated.'); }
}
