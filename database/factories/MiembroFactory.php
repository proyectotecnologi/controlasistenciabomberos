<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Miembro>
 */
class MiembroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grado'=>Str::random(length: 10),
            'cargo'=>Str::random(length: 10),
            'nombre_apellido'=>fake()->name,
            'ci'=>'6747483',
            'direccion'=>fake()->address,
            'telefono'=>random_int(70000000,79999999),
            'fecha_de_nacimiento'=>fake()->date($format = 'Y-m-d', $max = 'now'),
            'genero'=>'masculino',
            'email' =>fake()->unique()->safeEmail(),
            'estado'=>'1',
            'division_o_dependencia'=>'administrativa',
            'fotografia'=>'rene.jpg',
            'fecha_ingreso'=>fake()->date($format = 'Y-m-d')
        ];
    }
}
