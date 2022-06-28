<?php

namespace Tests\Feature\Http\Controllers\Acp;

use App\Models\Budget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Acp\BudgetController
 */
class BudgetControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $budgets = Budget::factory()->count(3)->create();

        $response = $this->get(route('budget.index'));

        $response->assertOk();
        $response->assertViewIs('budget.index');
        $response->assertViewHas('budgets');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('budget.create'));

        $response->assertOk();
        $response->assertViewIs('budget.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\BudgetController::class,
            'store',
            \App\Http\Requests\Acp\BudgetStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $start_date = $this->faker->date();
        $end_date = $this->faker->date();
        $limit = $this->faker->randomFloat(/** decimal_attributes **/);
        $notice = $this->faker->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();

        $response = $this->post(route('budget.store'), [
            'name' => $name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'limit' => $limit,
            'notice' => $notice,
            'user_id' => $user->id,
        ]);

        $budgets = Budget::query()
            ->where('name', $name)
            ->where('start_date', $start_date)
            ->where('end_date', $end_date)
            ->where('limit', $limit)
            ->where('notice', $notice)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $budgets);
        $budget = $budgets->first();

        $response->assertRedirect(route('budget.index'));
        $response->assertSessionHas('budget.id', $budget->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $budget = Budget::factory()->create();

        $response = $this->get(route('budget.show', $budget));

        $response->assertOk();
        $response->assertViewIs('budget.show');
        $response->assertViewHas('budget');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $budget = Budget::factory()->create();

        $response = $this->get(route('budget.edit', $budget));

        $response->assertOk();
        $response->assertViewIs('budget.edit');
        $response->assertViewHas('budget');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Acp\BudgetController::class,
            'update',
            \App\Http\Requests\Acp\BudgetUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $budget = Budget::factory()->create();
        $name = $this->faker->name;
        $start_date = $this->faker->date();
        $end_date = $this->faker->date();
        $limit = $this->faker->randomFloat(/** decimal_attributes **/);
        $notice = $this->faker->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();

        $response = $this->put(route('budget.update', $budget), [
            'name' => $name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'limit' => $limit,
            'notice' => $notice,
            'user_id' => $user->id,
        ]);

        $budget->refresh();

        $response->assertRedirect(route('budget.index'));
        $response->assertSessionHas('budget.id', $budget->id);

        $this->assertEquals($name, $budget->name);
        $this->assertEquals(Carbon::parse($start_date), $budget->start_date);
        $this->assertEquals(Carbon::parse($end_date), $budget->end_date);
        $this->assertEquals($limit, $budget->limit);
        $this->assertEquals($notice, $budget->notice);
        $this->assertEquals($user->id, $budget->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $budget = Budget::factory()->create();

        $response = $this->delete(route('budget.destroy', $budget));

        $response->assertRedirect(route('budget.index'));

        $this->assertDeleted($budget);
    }
}
