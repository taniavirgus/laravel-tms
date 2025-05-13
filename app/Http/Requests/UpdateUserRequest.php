<?php

namespace App\Http\Requests;

use App\Enums\RoleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true; // Authorization handled by UserPolicy
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => [
        'required',
        'string',
        'email',
        'max:255',
        Rule::unique('users')->ignore($this->user->id)
      ],
      'password' => ['nullable', 'confirmed', Password::defaults()],
      'role' => ['required', new Enum(RoleType::class)],
    ];
  }
}
