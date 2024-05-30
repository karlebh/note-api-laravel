<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginUserController extends Controller
{
  public function store(LoginUserRequest $request): JsonResponse
  {
    if (!Auth::attempt(($request->validated()))) {
      return response()->json(['message' => 'Incorrect data. Try again']);
    }

    $token  = $request->user()->createToken('Random Token')->accessToken;

    return response()->json(['token' => $token]);
  }

  public function destroy(): JsonResponse
  {
    auth()->user()->token()->revoke();

    return response()->json(['message' => 'User Logged Out']);
  }
}
