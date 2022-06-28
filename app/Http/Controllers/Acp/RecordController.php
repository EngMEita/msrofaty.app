<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\RecordStoreRequest;
use App\Http\Requests\Acp\RecordUpdateRequest;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Record::all();

        return view('acp.record.index', compact('records'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('acp.record.create');
    }

    /**
     * @param \App\Http\Requests\Acp\RecordStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecordStoreRequest $request)
    {
        $record = Record::create($request->validated());

        $request->session()->flash('record.id', $record->id);

        return redirect()->route('record.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Record $record)
    {
        return view('acp.record.show', compact('record'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Record $record)
    {
        return view('acp.record.edit', compact('record'));
    }

    /**
     * @param \App\Http\Requests\Acp\RecordUpdateRequest $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function update(RecordUpdateRequest $request, Record $record)
    {
        $record->update($request->validated());

        $request->session()->flash('record.id', $record->id);

        return redirect()->route('record.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Record $record)
    {
        $record->delete();

        return redirect()->route('record.index');
    }
}
