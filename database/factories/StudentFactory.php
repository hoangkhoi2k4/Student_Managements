<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => $this->generatePhoneNumber(),
            'status' => 1,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement([1, 2]),
            'department_id' => $this->faker->randomElement([4, 5]),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Student $student) {
            $student->student_code = date('Y') . $student->user_id;
            $student->save();
        });
    }

    private function generatePhoneNumber()
    {
        // Generate a random number with 9 digits, then prepend '0'
        return '0' . $this->faker->numerify('#########');
    }
}
