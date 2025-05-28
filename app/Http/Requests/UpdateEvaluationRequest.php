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
      'description' => ['required', 'string'],
      'point' => ['required', 'integer', 'min:0'],
      'target' => ['required', 'integer', 'min:0'],
      'topic_id' => ['required', 'exists:topics,id'],
      'department_id' => ['required', 'exists:departments,id'],
      'position_id' => ['required', 'exists:positions,id']
    ];
  }
}
