<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['nullable', 'string', 'min:4', 'max:20', 'unique:' . User::class],
      'email' => ['nullable', 'string', 'email', 'max:255', 'unique:' . User::class],
      'role' => ['nullable', 'string'],
      'password' => [
        'nullable', 'confirmed', Rules\Password::min(8)
          ->letters()
          ->numbers()
          ->symbols()
      ],
    ];
  }
}
