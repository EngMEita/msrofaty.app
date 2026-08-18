<?php
namespace App\Http\Controllers\Acp;
use App\Http\Controllers\Controller;
use App\Models\CurrencyConversion;
use Illuminate\Http\Request;
class CurrencyConversionController extends Controller {
 public function index(){ $h=auth()->user()->household(); $conversions=$h->currencyConversions()->with(['fromAccount','toAccount','fromCurrency','toCurrency'])->latest('date')->paginate(20); $accounts=$h->accounts()->with('currency')->orderBy('name')->get(); $currencies=$h->currencies()->where('active',true)->orderBy('code')->get(); return view('acp.currency.conversions',compact('conversions','accounts','currencies')); }
 public function store(Request $request){ $h=auth()->user()->household(); $data=$request->validate(['from_account_id'=>'required|integer','to_account_id'=>'required|integer|different:from_account_id','from_currency_id'=>'required|integer','to_currency_id'=>'required|integer|different:from_currency_id','from_amount'=>'required|numeric|gt:0','rate'=>'required|numeric|gt:0','date'=>'required|date','note'=>'nullable|string']); abort_unless($h->accounts()->whereKey($data['from_account_id'])->exists()&&$h->accounts()->whereKey($data['to_account_id'])->exists(),422); abort_unless($h->currencies()->whereKey($data['from_currency_id'])->exists()&&$h->currencies()->whereKey($data['to_currency_id'])->exists(),422); $data['to_amount']=round($data['from_amount']*$data['rate'],2); $h->currencyConversions()->create($data); return back()->with('message','تم تسجيل معاملة التحويل.'); }
}
