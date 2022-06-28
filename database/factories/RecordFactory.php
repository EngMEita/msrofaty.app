<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Record;

class RecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Record::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'entry_id' => Entry::factory(),
            'account_id' => Account::factory(),
            'type' => $this->faker->randomElement(["-1","1"]),
            'value' => $this->faker->randomFloat(2, 0, 999999.99),
            'category_id' => Category::factory(),
            'comment' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
