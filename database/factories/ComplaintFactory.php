<?php

namespace Database\Factories;

use App\Models\Complaint;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition(): array
    {
        return [
            'citizen_name'     => $this->faker->name(),
            'citizen_phone'    => '03' . $this->faker->numerify('#########'),
            'shop_name'        => $this->faker->company() . ' Store',
            'location_address' => $this->faker->address(),
            'description'      => $this->faker->paragraph(3),
            'photo_path'       => null,
            'status'           => 'Pending',
        ];
    }
}