<?php

namespace App\Http\Requests;

use App\Enums\GenderType;
use App\Enums\ReligionType;
use App\Enums\StatusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEmployeeRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
      'phone' => ['required', 'string', 'max:20'],
      'address' => ['required', 'string', 'max:500'],
      'birthdate' => ['required', 'date'],
      'gender' => ['required', new Enum(GenderType::class)],
      'religion' => ['required', new Enum(ReligionType::class)],
      'status' => ['required', new Enum(StatusType::class)],
      'department_id' => ['required', 'exists:departments,id'],
      'position_id' => ['required', 'exists:positions,id'],
    ];
  }
}
