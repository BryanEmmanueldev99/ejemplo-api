<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productos>
 */
class ProductosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'nombre_producto' => $this->faker->name,
            'descripcion' => $this->faker->paragraph,
            'precio' => $this->faker->numberBetween(100,200),
            'stock'  => $this->faker->numberBetween(10,200),
            'imagen' => $this->faker->image,
            'id_categoria'  => $this->faker->numberBetween(1,5),
        ];
    }
}
