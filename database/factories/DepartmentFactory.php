<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        static $names = ['CITE', 'CBEA', 'CITHM', 'BED', 'SDS', 'CAMP', 'CASE'];

        // Shift the first element off the array and return it
        $name = array_shift($names);

        return [
            'name' => $name,
        ];
    }
}
