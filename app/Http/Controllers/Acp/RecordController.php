<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\RecordStoreRequest;
use App\Http\Requests\Acp\RecordUpdateRequest;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $records = Record::whereHas('entry', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->with(['entry', 'account', 'category'])
            ->latest('created_at')
            ->paginate(50);

        return view('acp.record.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $entries = auth()->user()->entries()->pluck('id');
        $accounts = \App\Models\Account::all();
        $categories = \App\Models\Category::all();

        return view('acp.record.create', compact('entries', 'accounts', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordStoreRequest $request): RedirectResponse
    {
        // Validate that entry belongs to authenticated user
        $entry = \App\Models\Entry::findOrFail($request->entry_id);
        $this->authorize('update', $entry);

        $record = Record::create($request->validated());

        $request->session()->flash('message', 'Record created successfully.');

        return redirect()->route('acp.record.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Record $record): View
    {
        $this->authorize('view', $record);

        return view('acp.record.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Record $record): View
    {
        $this->authorize('update', $record);

        $entries = auth()->user()->entries()->pluck('id');
        $accounts = \App\Models\Account::all();
        $categories = \App\Models\Category::all();

        return view('acp.record.edit', compact('record', 'entries', 'accounts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecordUpdateRequest $request, Record $record): RedirectResponse
    {
        $this->authorize('update', $record);

        $record->update($request->validated());

        $request->session()->flash('message', 'Record updated successfully.');

        return redirect()->route('acp.record.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Record $record): RedirectResponse
    {
        $this->authorize('delete', $record);

        $record->delete();

        return redirect()->route('acp.record.index')->with('message', 'Record deleted successfully.');
    }
}
