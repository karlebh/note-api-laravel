<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): JsonResponse
  {
    return response()->json(['users' => User::paginate()]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request): JsonResponse
  {
    $all = $request->validate([
      'name' => ['required', 'string', 'min:4', 'max:20', 'unique:' . User::class],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $data = array_merge(
      $all,
      ['password' => Hash::make($request->password)]
    );

    $user = User::create($data);


    return response()->json(['message' => 'User created successfully']);
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user): JsonResponse
  {
    return response()->json(['user' => $user]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateUserRequest $request, User $user): JsonResponse
  {
    $user->update($request->validated());

    return response()->json(['message' => 'User details updated successfully']);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user): JsonResponse
  {
    abort_if(auth()->user()->role !== 'admin', 403, 'Unathorized: only admin can delete users');

    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
  }
}
