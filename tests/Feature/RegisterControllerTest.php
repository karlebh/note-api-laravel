<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_user_can_be_created(): void
  {
    $this->postJson('/api/register', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'user_one_20204',
      'password_confirmation' => 'user_one_20204'
    ]);

    $this->assertCount(1, User::all());
    $this->assertEquals('User 1', User::first()->name);
  }

  public function test_only_unique_name_is_allowed(): void
  {
    $this->postJson('/api/register', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'user_one_20204',
      'password_confirmation' => 'user_one_20204'
    ]);

    $response = $this->postJson('/api/register', [
      'name' => 'User 1',
      'email' => 'user12@example.com',
      'password' => 'user_one_2024',
      'password_confirmation' => 'user_one_2024'
    ]);

    $response->assertInvalid(['name']);
    $this->assertCount(1, User::all());
  }

  public function test_only_unique_email_is_allowed(): void
  {
    $this->postJson('/api/register', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'user_one_20204',
      'password_confirmation' => 'user_one_20204'
    ]);

    $response = $this->postJson('/api/register', [
      'name' => 'User 2',
      'email' => 'user1@example.com',
      'password' => 'user_one_2024',
      'password_confirmation' => 'user_one_2024'
    ]);

    $response->assertInvalid(['email']);
    $this->assertCount(1, User::all());
  }

  public function test_users_with_unique_email_and_name_have_no_problem_creating_accounts(): void
  {
    $this->postJson('/api/register', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'user_one_20204',
      'password_confirmation' => 'user_one_20204'
    ]);

    $response = $this->postJson('/api/register', [
      'name' => 'User 2',
      'email' => 'user2@example.com',
      'password' => 'user_one_2024',
      'password_confirmation' => 'user_one_2024'
    ]);

    $response->assertSessionDoesntHaveErrors();
    $this->assertCount(2, User::all());
  }

  public function test_only_valid_email_allowed(): void
  {
    $response = $this->postJson('/api/register', [
      'name' => 'User 1',
      'email' => 'user1examplecom',
      'password' => 'one_strong_password_31',
      'password_confirmation' => 'one_strong_password_31'
    ]);

    $response->assertInvalid(['email']);
    $this->assertCount(0, User::all());
  }

  public function test_all_fileds_are_required(): void
  {
    $response = $this->postJson('/api/register', [
      'name' => '',
      'email' => '',
      'password' => 'one_strong_password_31',
      'password_confirmation' => 'one_strong_password_31'
    ]);

    $response->assertInvalid(['email', 'name']);
    $this->assertCount(0, User::all());
  }

  public function test_password_has_to_match_password_confirmation_column(): void
  {
    $response = $this->postJson('/api/register', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'one_strang_password_31',
      'password_confirmation' => 'user_one_20204'
    ]);

    $response->assertInvalid(['password']);
    $this->assertCount(0, User::all());
  }
}
