<?php

namespace Tests\Feature\Http\Controllers\Acp;

use App\Models\Account;
use App\Models\Entry;
use App\Models\Record;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Acp\RecordController
 */
class RecordControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $records = Record::factory()->count(3)->create();

        $response = $this->get(route('record.index'));

        $response->assertOk();
        $response->assertViewIs('record.index');
        $response->assertViewHas('records');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('record.create'));

        $response->assertOk();
        $response->assertViewIs('record.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\RecordController::class,
            'store',
            \App\Http\Requests\Acp\RecordStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $entry = Entry::factory()->create();
        $account = Account::factory()->create();
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $value = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('record.store'), [
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => $type,
            'value' => $value,
        ]);

        $records = Record::query()
            ->where('entry_id', $entry->id)
            ->where('account_id', $account->id)
            ->where('type', $type)
            ->where('value', $value)
            ->get();
        $this->assertCount(1, $records);
        $record = $records->first();

        $response->assertRedirect(route('record.index'));
        $response->assertSessionHas('record.id', $record->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $record = Record::factory()->create();

        $response = $this->get(route('record.show', $record));

        $response->assertOk();
        $response->assertViewIs('record.show');
        $response->assertViewHas('record');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $record = Record::factory()->create();

        $response = $this->get(route('record.edit', $record));

        $response->assertOk();
        $response->assertViewIs('record.edit');
        $response->assertViewHas('record');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\RecordController::class,
            'update',
            \App\Http\Requests\Acp\RecordUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $record = Record::factory()->create();
        $entry = Entry::factory()->create();
        $account = Account::factory()->create();
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $value = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('record.update', $record), [
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => $type,
            'value' => $value,
        ]);

        $record->refresh();

        $response->assertRedirect(route('record.index'));
        $response->assertSessionHas('record.id', $record->id);

        $this->assertEquals($entry->id, $record->entry_id);
        $this->assertEquals($account->id, $record->account_id);
        $this->assertEquals($type, $record->type);
        $this->assertEquals($value, $record->value);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $record = Record::factory()->create();

        $response = $this->delete(route('record.destroy', $record));

        $response->assertRedirect(route('record.index'));

        $this->assertDeleted($record);
    }
}
