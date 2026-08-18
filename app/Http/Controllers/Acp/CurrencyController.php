<?php
namespace App\Http\Controllers\Acp;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
class CurrencyController extends Controller {
 public function index(){ $currencies=auth()->user()->household()->currencies()->latest()->get(); return view('acp.currency.index',compact('currencies')); }
 public function store(Request $request){ $data=$request->validate(['code'=>['required','string','size:3','alpha','uppercase'],'name'=>['required','string','max:80'],'symbol'=>['nullable','string','max:8'],'is_base'=>['boolean']]); $h=auth()->user()->household(); if(!empty($data['is_base'])) $h->currencies()->update(['is_base'=>false]); $h->currencies()->create(array_merge($data,['code'=>strtoupper($data['code'])])); return back()->with('message','تم حفظ العملة.'); }
 public function update(Request $request,Currency $currency){ abort_unless($currency->household_id===auth()->user()->household()->id,404); $data=$request->validate(['name'=>['required','string','max:80'],'symbol'=>['nullable','string','max:8'],'active'=>['boolean']]); $currency->update($data); return back()->with('message','تم تحديث العملة.'); }
 public function destroy(Currency $currency){ abort_unless($currency->household_id===auth()->user()->household()->id,404); abort_if($currency->is_base,422,'لا يمكن حذف العملة الأساسية.'); $currency->delete(); return back()->with('message','تم حذف العملة.'); }
}
