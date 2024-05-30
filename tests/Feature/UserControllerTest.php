<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

  use RefreshDatabase;

  public function test_guest_can_not_create_other_users(): void
  {
    $this->postJson('/api/user', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'user_one_20204',
      'password_confirmation' => 'user_one_20204'
    ]);

    $this->assertCount(0, User::all());
  }

  public function test_user_can_create_other_users(): void
  {
    $user = User::factory()->create();

    Passport::actingAs(
      $user
    );

    $response =  $this->postJson('/api/user', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'user_one_20204',
      'password_confirmation' => 'user_one_20204'
    ]);

    $response->assertStatus(200);
    $this->assertCount(2, User::all());
  }

  public function test_an_existing_user_can_be_edited_by_user(): void
  {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    Passport::actingAs($user1);

    $response = $this->putJson('/api/user/' . $user2->id, [
      'name' => 'Updated Name',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
      'id' => $user2->id,
      'name' => 'Updated Name',
    ]);
  }
  public function test_guest_can_not_delete_user(): void
  {
    $response = $this->deleteJson('/api/user/1');

    $response->assertStatus(401);
  }


  public function test_regular_user_can_not_delete_user(): void
  {
    $user = User::factory()->regularUser()->create();

    Passport::actingAs(
      $user
    );

    $this->postJson('/api/user', [
      'name' => 'User 1',
      'email' => 'user1@example.com',
      'password' => 'user_one_20204',
      'password_confirmation' => 'user_one_20204'
    ]);

    $response = $this->deleteJson('/api/user/1');

    // $response->assertStatus(403);
    $this->assertCount(2, User::all());
  }

  public function test_only_admin_can_delete_a_user(): void
  {
    $user2 = User::factory()->regularUser()->create();
    $user = User::factory()->admin()->create();

    Passport::actingAs(
      $user
    );

    $this->assertCount(2, User::all());

    $response = $this->deleteJson("/api/user/" . $user2->id);

    $response->assertOk();
    $this->assertCount(1, User::all());
    $this->assertEquals('admin', $user->role);
  }
}
