<?php

namespace Database\Factories;

use App\Models\Commodity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commodity>
 */
class CommodityFactory extends Factory
{
    protected $model = Commodity::class;

    public function definition(): array
    {
        $items = ['Sugar', 'Flour', 'Rice', 'Oil', 'Milk', 'Onion', 'Tomato', 'Potato'];
        $units = ['kg', 'litre', 'gram', 'dozen'];

        return [
            'name'      => $this->faker->unique()->randomElement($items) . ' ' . $this->faker->word(),
            'urdu_name' => null,
            'unit'      => $this->faker->randomElement($units),
        ];
    }
}