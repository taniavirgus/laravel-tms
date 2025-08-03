<?php

namespace App\Http\Requests;

use App\Enums\SegmentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTalentTrainingRequest extends FormRequest
{
  /**
   * Number of days after today that the start date must be.
   * 
   * @var int
   */
  protected int $minimum = 3;

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
      'start_date' => ['required', 'date', 'after:' . now()->addDays(3)->format('Y-m-d')],
      'end_date' => ['required', 'date', 'after_or_equal:start_date'],
      'duration' => ['required', 'integer', 'min:0'],
      'segment' => ['required', new Enum(SegmentType::class)],
      'start_at' => ['nullable', 'date_format:H:i'],
      'location' => ['nullable', 'string', 'max:255'],
    ];
  }

  /**
   * Custom message for minimum date.
   */
  public function messages(): array
  {
    return [
      'start_date.after' => "The start date must be at least " . $this->minimum . " days after today.",
    ];
  }
}
