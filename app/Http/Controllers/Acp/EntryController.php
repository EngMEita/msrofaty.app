<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\EntryStoreRequest;
use App\Http\Requests\Acp\EntryUpdateRequest;
use App\Models\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $entries = Entry::all();

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
    public function store(EntryStoreRequest $request)
    {
        $entry = Entry::create($request->validated());

        $request->session()->flash('entry.id', $entry->id);

        return redirect()->route('entry.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Entry $entry)
    {
        return view('acp.entry.show', compact('entry'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Entry $entry)
    {
        return view('acp.entry.edit', compact('entry'));
    }

    /**
     * @param \App\Http\Requests\Acp\EntryUpdateRequest $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryUpdateRequest $request, Entry $entry)
    {
        $entry->update($request->validated());

        $request->session()->flash('entry.id', $entry->id);

        return redirect()->route('entry.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry)
    {
        $entry->delete();

        return redirect()->route('entry.index');
    }
}
