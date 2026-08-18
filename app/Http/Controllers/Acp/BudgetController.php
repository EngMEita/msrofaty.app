<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\BudgetStoreRequest;
use App\Http\Requests\Acp\BudgetUpdateRequest;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of budgets for authenticated user.
     */
    public function index(Request $request): View
    {
        $budgets = auth()->user()->budgets()
            ->with(['categories'])
            ->latest('created_at')
            ->paginate(20);

        return view('acp.budget.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new budget.
     */
    public function create(Request $request): View
    {
        $categories = \App\Models\Category::all();
        return view('acp.budget.create', compact('categories'));
    }

    /**
     * Store a newly created budget in storage.
     */
    public function store(BudgetStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $budget = Budget::create($data);

        // Attach categories if provided
        if ($request->has('categories')) {
            $budget->categories()->sync($request->input('categories'));
        }

        return redirect()->route('acp.budget.index')->with('message', 'Budget created successfully.');
    }

    /**
     * Display the specified budget.
     */
    public function show(Request $request, Budget $budget): View
    {
        $this->authorize('view', $budget);

        return view('acp.budget.show', compact('budget'));
    }

    /**
     * Show the form for editing the specified budget.
     */
    public function edit(Request $request, Budget $budget): View
    {
        $this->authorize('update', $budget);

        $categories = \App\Models\Category::all();
        $selectedCategories = $budget->categories->pluck('id')->toArray();

        return view('acp.budget.edit', compact('budget', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified budget in storage.
     */
    public function update(BudgetUpdateRequest $request, Budget $budget): RedirectResponse
    {
        $this->authorize('update', $budget);

        $budget->update($request->validated());

        // Update categories if provided
        if ($request->has('categories')) {
            $budget->categories()->sync($request->input('categories'));
        }

        return redirect()->route('acp.budget.index')->with('message', 'Budget updated successfully.');
    }

    /**
     * Remove the specified budget from storage.
     */
    public function destroy(Request $request, Budget $budget): RedirectResponse
    {
        $this->authorize('delete', $budget);

        $budget->delete();

        return redirect()->route('acp.budget.index')->with('message', 'Budget deleted successfully.');
    }
}
