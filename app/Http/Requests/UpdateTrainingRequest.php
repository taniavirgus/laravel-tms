<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingRequest extends FormRequest
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
      'description' => ['required', 'string'],
      'department_id' => ['required', 'integer', 'exists:departments,id'],
      'evaluation_id' => ['required', 'integer', 'exists:evaluations,id'],
      'start_date' => ['required', 'date'],
      'end_date' => ['required', 'date', 'after:start_date'],
      'duration' => ['required', 'integer', 'min:0'],
      'capacity' => ['required', 'integer', 'min:0'],
    ];
  }
}
