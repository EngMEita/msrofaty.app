<?php

namespace Tests\Feature\Http\Controllers\Acp;

use App\Models\Entry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Acp\EntryController
 */
class EntryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $entries = Entry::factory()->count(3)->create();

        $response = $this->get(route('entry.index'));

        $response->assertOk();
        $response->assertViewIs('entry.index');
        $response->assertViewHas('entries');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('entry.create'));

        $response->assertOk();
        $response->assertViewIs('entry.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\EntryController::class,
            'store',
            \App\Http\Requests\Acp\EntryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $date = $this->faker->date();
        $user = User::factory()->create();

        $response = $this->post(route('entry.store'), [
            'date' => $date,
            'user_id' => $user->id,
        ]);

        $entries = Entry::query()
            ->where('date', $date)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $entries);
        $entry = $entries->first();

        $response->assertRedirect(route('entry.index'));
        $response->assertSessionHas('entry.id', $entry->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $entry = Entry::factory()->create();

        $response = $this->get(route('entry.show', $entry));

        $response->assertOk();
        $response->assertViewIs('entry.show');
        $response->assertViewHas('entry');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $entry = Entry::factory()->create();

        $response = $this->get(route('entry.edit', $entry));

        $response->assertOk();
        $response->assertViewIs('entry.edit');
        $response->assertViewHas('entry');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\EntryController::class,
            'update',
            \App\Http\Requests\Acp\EntryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $entry = Entry::factory()->create();
        $date = $this->faker->date();
        $user = User::factory()->create();

        $response = $this->put(route('entry.update', $entry), [
            'date' => $date,
            'user_id' => $user->id,
        ]);

        $entry->refresh();

        $response->assertRedirect(route('entry.index'));
        $response->assertSessionHas('entry.id', $entry->id);

        $this->assertEquals(Carbon::parse($date), $entry->date);
        $this->assertEquals($user->id, $entry->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $entry = Entry::factory()->create();

        $response = $this->delete(route('entry.destroy', $entry));

        $response->assertRedirect(route('entry.index'));

        $this->assertDeleted($entry);
    }
}
