<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationRequest extends FormRequest
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
      'description' => ['nullable', 'string'],
      'point' => ['required', 'integer', 'min:0'],
      'target' => ['required', 'integer', 'min:0'],
      'weight' => ['required', 'integer', 'min:0', 'max:100'],
      'department_id' => ['required', 'exists:departments,id'],
      'topic_id' => ['required', 'exists:topics,id'],
    ];
  }
}
