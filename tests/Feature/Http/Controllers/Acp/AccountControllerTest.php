<?php

namespace Tests\Feature\Http\Controllers\Acp;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Acp\AccountController
 */
class AccountControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $accounts = Account::factory()->count(3)->create();

        $response = $this->get(route('account.index'));

        $response->assertOk();
        $response->assertViewIs('account.index');
        $response->assertViewHas('accounts');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('account.create'));

        $response->assertOk();
        $response->assertViewIs('account.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\AccountController::class,
            'store',
            \App\Http\Requests\Acp\AccountStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;

        $response = $this->post(route('account.store'), [
            'name' => $name,
        ]);

        $accounts = Account::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $accounts);
        $account = $accounts->first();

        $response->assertRedirect(route('account.index'));
        $response->assertSessionHas('account.id', $account->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $account = Account::factory()->create();

        $response = $this->get(route('account.show', $account));

        $response->assertOk();
        $response->assertViewIs('account.show');
        $response->assertViewHas('account');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $account = Account::factory()->create();

        $response = $this->get(route('account.edit', $account));

        $response->assertOk();
        $response->assertViewIs('account.edit');
        $response->assertViewHas('account');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\AccountController::class,
            'update',
            \App\Http\Requests\Acp\AccountUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $account = Account::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('account.update', $account), [
            'name' => $name,
        ]);

        $account->refresh();

        $response->assertRedirect(route('account.index'));
        $response->assertSessionHas('account.id', $account->id);

        $this->assertEquals($name, $account->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $account = Account::factory()->create();

        $response = $this->delete(route('account.destroy', $account));

        $response->assertRedirect(route('account.index'));

        $this->assertDeleted($account);
    }
}
