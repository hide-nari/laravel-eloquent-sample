<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PersonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'age'        => $this->faker->numberBetween($min = 15, $max = 150),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
