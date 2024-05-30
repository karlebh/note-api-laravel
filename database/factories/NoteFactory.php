<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = fake()->sentence();

    return [
      'title' => $title,
      'user_id' => array_rand([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
      'body' => fake()->paragraph(),
    ];
  }
}
