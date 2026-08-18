<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\AccountStoreRequest;
use App\Http\Requests\Acp\AccountUpdateRequest;
use App\Models\Account;
use App\Services\HouseholdPlanService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index($account_id = null)
    {
        $accounts = auth()->user()->household()->accounts()->get();
        return view('acp.account.index', compact('accounts'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('acp.account.create');
    }

    /**
     * @param \App\Http\Requests\Acp\AccountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountStoreRequest $request, HouseholdPlanService $plans)
    {
        $plans->assertWithinLimit(auth()->user()->household(), 'accounts');
        $account = Account::create(array_merge($request->validated(), ['household_id' => auth()->user()->household()->id]));

        $request->session()->flash('account.id', $account->id);

        return redirect()->route('acp.account.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Account $account)
    {
        abort_unless($account->household_id === auth()->user()->household()->id, 404);
        return view('acp.account.show', compact('account'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accounts = auth()->user()->household()->accounts()->get();
        $current  = Account::findOrFail($id);
        abort_unless($current->household_id === auth()->user()->household()->id, 404);
        return view('acp.account.index', compact('current', 'accounts'));
    }

    /**
     * @param \App\Http\Requests\Acp\AccountUpdateRequest $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function update(AccountUpdateRequest $request, Account $account)
    {
        abort_unless($account->household_id === auth()->user()->household()->id, 404);
        $account->update($request->validated());

        $request->session()->flash('account.id', $account->id);

        return redirect()->route('acp.account.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Account $account)
    {
        abort_unless($account->household_id === auth()->user()->household()->id, 404);
        $account->delete();

        return redirect()->route('acp.account.index');
    }
}
