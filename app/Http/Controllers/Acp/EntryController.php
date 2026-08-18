<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\EntryStoreRequest;
use App\Http\Requests\Acp\EntryUpdateRequest;
use App\Models\Entry;
use Illuminate\Http\Request;
use App\Services\HouseholdPlanService;
use Illuminate\Support\Facades\DB;

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
        $household = auth()->user()->household();
        return view('acp.entry.create', [
            'today' => now()->format('Y-m-d'),
            'accounts' => $household->accounts()->orderBy('name')->get(),
            'categories' => $household->categories()->orderBy('name')->get(),
        ]);
    }

    /**
     * @param \App\Http\Requests\Acp\EntryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryStoreRequest $request, HouseholdPlanService $plans)
    {
        $plans->assertWithinLimit(auth()->user()->household(), 'transactions');
        $household = auth()->user()->household();
        $data = $request->validated();
        $data['entry_type'] = $data['entry_type'] ?? 'expense';
        $records = $data['records'] ?? [];
        unset($data['records']);
        $paymentSplits = $data['payment_splits'] ?? [];
        unset($data['payment_splits']);
        foreach ($records as $record) {
            abort_unless($household->accounts()->whereKey($record['account_id'])->exists(), 422);
            if (!empty($record['category_id'])) {
                abort_unless($household->categories()->whereKey($record['category_id'])->exists(), 422);
            }
        }
        foreach ($paymentSplits as $split) abort_unless($household->accounts()->whereKey($split['account_id'])->exists(), 422);
        $entry = DB::transaction(function () use ($data, $records, $paymentSplits, $household) {
            $entry = Entry::create(array_merge($data, ['user_id' => auth()->id(), 'household_id' => $household->id, 'workflow_status' => 'draft', 'reference_number' => 'OP-' . now()->format('YmdHis') . '-' . random_int(100, 999)]));
            foreach ($records as $record) {
                $entry->records()->create(array_merge($record, ['household_id' => $household->id]));
            }
            foreach ($paymentSplits as $split) $entry->paymentSplits()->create($split);
            $entry->refresh();
            $allocated = (float) $entry->records()->sum('value');
            $paid = (float) $entry->paymentSplits()->sum('amount');
            $entry->update(['workflow_status' => abs((float) $entry->total_amount - $allocated) < .01 && abs((float) $entry->total_amount - $paid) < .01 ? 'balanced' : (count($records) || count($paymentSplits) ? 'allocated' : 'draft')]);
            return $entry;
        });

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
        $entry->load(['records.account', 'records.category', 'paymentSplits.account']);
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
        $household = auth()->user()->household();
        $entry->load(['records', 'paymentSplits']);
        return view('acp.entry.edit', ['entry' => $entry, 'accounts' => $household->accounts()->orderBy('name')->get(), 'categories' => $household->categories()->orderBy('name')->get()]);
    }

    /**
     * @param \App\Http\Requests\Acp\EntryUpdateRequest $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryUpdateRequest $request, Entry $entry)
    {
        $household = auth()->user()->household();
        $data = $request->validated();
        $data['entry_type'] = $data['entry_type'] ?? 'expense';
        $records = $data['records'] ?? [];
        unset($data['records']);
        $paymentSplits = $data['payment_splits'] ?? [];
        unset($data['payment_splits']);
        foreach ($records as $record) {
            abort_unless($household->accounts()->whereKey($record['account_id'])->exists(), 422);
            if (!empty($record['category_id'])) abort_unless($household->categories()->whereKey($record['category_id'])->exists(), 422);
        }
        foreach ($paymentSplits as $split) abort_unless($household->accounts()->whereKey($split['account_id'])->exists(), 422);
        DB::transaction(function () use ($entry, $data, $records, $paymentSplits, $household) {
            $entry->update(array_merge($data, ['user_id' => auth()->id()]));
            $entry->records()->delete();
            foreach ($records as $record) $entry->records()->create(array_merge($record, ['household_id' => $household->id]));
            $entry->paymentSplits()->delete();
            foreach ($paymentSplits as $split) $entry->paymentSplits()->create($split);
            $allocated = (float) $entry->records()->sum('value');
            $paid = (float) $entry->paymentSplits()->sum('amount');
            $entry->update(['workflow_status' => abs((float) $entry->total_amount - $allocated) < .01 && abs((float) $entry->total_amount - $paid) < .01 ? 'balanced' : (count($records) || count($paymentSplits) ? 'allocated' : 'draft')]);
        });

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
