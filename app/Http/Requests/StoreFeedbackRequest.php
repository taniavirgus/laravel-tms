<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
      'teamwork' => ['integer', 'between:0,100'],
      'communication' => ['integer', 'between:0,100'],
      'initiative' => ['integer', 'between:0,100'],
      'problem_solving' => ['integer', 'between:0,100'],
      'adaptability' => ['integer', 'between:0,100'],
      'talent' => ['integer', 'between:0,100'],
      'description' => ['string', 'max:255'],
    ];
  }
}
