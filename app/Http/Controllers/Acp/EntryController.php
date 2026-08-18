<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\EntryStoreRequest;
use App\Http\Requests\Acp\EntryUpdateRequest;
use App\Models\Entry;
use Illuminate\Http\Request;
use App\Services\HouseholdPlanService;

class EntryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $entries = auth()->user()->household()->entries()->with('records')->latest('date')->paginate(20);

        return view('acp.entry.index', compact('entries'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('acp.entry.create');
    }

    /**
     * @param \App\Http\Requests\Acp\EntryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryStoreRequest $request, HouseholdPlanService $plans)
    {
        $plans->assertWithinLimit(auth()->user()->household(), 'transactions');
        $entry = Entry::create(array_merge($request->validated(), [
            'user_id' => auth()->id(),
            'household_id' => auth()->user()->household()->id,
        ]));

        $request->session()->flash('entry.id', $entry->id);

        return redirect()->route('acp.entry.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Entry $entry)
    {
        $this->authorize('view', $entry);
        return view('acp.entry.show', compact('entry'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Entry $entry)
    {
        $this->authorize('update', $entry);
        return view('acp.entry.edit', compact('entry'));
    }

    /**
     * @param \App\Http\Requests\Acp\EntryUpdateRequest $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryUpdateRequest $request, Entry $entry)
    {
        $entry->update(array_merge($request->validated(), ['user_id' => auth()->id()]));

        $request->session()->flash('entry.id', $entry->id);

        return redirect()->route('acp.entry.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry)
    {
        $this->authorize('delete', $entry);
        $entry->delete();

        return redirect()->route('acp.entry.index');
    }
}
