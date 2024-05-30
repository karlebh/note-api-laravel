<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;


class LoginControllerTest extends TestCase
{

  use RefreshDatabase;

  public function test_user_can_log_in(): void
  {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
      'email' => $user->email,
      'password' => $user->password,
    ]);

    $response->assertOk();
    $response->assertSessionDoesntHaveErrors();
  }

  public function test_email_input_data_is_needed_for_log_in(): void
  {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
      'email' => '',
      'password' => $user->password,
    ]);

    $response->assertInvalid(['email']);
  }

  public function test_password_input_data_is_needed_for_log_in(): void
  {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
      'email' => $user->email,
      'password' => '',
    ]);

    $response->assertInvalid(['password']);
  }

  public function test_already_logged_in_user_can_not_login_again(): void
  {
    $user = User::factory()->create();

    Passport::actingAs($user);

    $response = $this->postJson('/api/login', [
      'email' => $user->email,
      'password' => $user->password,
    ]);

    $response->assertRedirect();
  }

  public function test_logged_in_user_can_log_out(): void
  {
    $user = User::factory()->create();

    Passport::actingAs(
      $user
    );

    $this->postJson('/api/logout');

    $this->assertFalse($user->token()->exists());
  }
}
