<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\BudgetStoreRequest;
use App\Http\Requests\Acp\BudgetUpdateRequest;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $budgets = Budget::all();

        return view('acp.budget.index', compact('budgets'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('acp.budget.create');
    }

    /**
     * @param \App\Http\Requests\Acp\BudgetStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BudgetStoreRequest $request)
    {
        $budget = Budget::create($request->validated());

        $request->session()->flash('budget.id', $budget->id);

        return redirect()->route('budget.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Budget $budget)
    {
        return view('acp.budget.show', compact('budget'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Budget $budget)
    {
        return view('acp.budget.edit', compact('budget'));
    }

    /**
     * @param \App\Http\Requests\Acp\BudgetUpdateRequest $request
     * @param \App\Models\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function update(BudgetUpdateRequest $request, Budget $budget)
    {
        $budget->update($request->validated());

        $request->session()->flash('budget.id', $budget->id);

        return redirect()->route('budget.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Budget $budget)
    {
        $budget->delete();

        return redirect()->route('budget.index');
    }
}
