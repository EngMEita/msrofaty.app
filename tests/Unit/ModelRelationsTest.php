<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_entries()
    {
        $user = User::factory()->create();
        $user->entries()->create([
            'date' => now(),
            'note' => 'Test entry',
        ]);

        $this->assertCount(1, $user->entries);
    }

    public function test_user_has_many_budgets()
    {
        $user = User::factory()->create();
        $user->budgets()->create([
            'name' => 'Test Budget',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'limit' => 1000,
            'notice' => 800,
        ]);

        $this->assertCount(1, $user->budgets);
    }

    public function test_budget_belongs_to_many_categories()
    {
        $budget = Budget::factory()->create();
        $category1 = Category::create(['name' => 'Category 1']);
        $category2 = Category::create(['name' => 'Category 2']);

        $budget->categories()->attach([$category1->id, $category2->id]);

        $this->assertCount(2, $budget->categories);
    }

    public function test_category_belongs_to_many_budgets()
    {
        $category = Category::create(['name' => 'Test Category']);
        $budget1 = Budget::factory()->create();
        $budget2 = Budget::factory()->create();

        $budget1->categories()->attach($category->id);
        $budget2->categories()->attach($category->id);

        $this->assertCount(2, $category->budgets);
    }

    public function test_category_has_many_subcategories()
    {
        $parentCategory = Category::create(['name' => 'Parent']);
        $childCategory = Category::create([
            'name' => 'Child',
            'category_id' => $parentCategory->id,
        ]);

        $this->assertCount(1, $parentCategory->subcategories);
        $this->assertEquals($parentCategory->id, $childCategory->parentCategory->id);
    }
}
