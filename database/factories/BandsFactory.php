<?php

namespace Database\Factories;

use App\Models\Bands;
use Illuminate\Database\Eloquent\Factories\Factory;

class BandsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bands::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'discription' => $this->faker->paragraph,
            'color_txt' => $this->faker->hexcolor,
            'color_bg' => $this->faker->hexcolor,
        ];
    }
}
