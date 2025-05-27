<?php

namespace App\Http\Requests;

use App\Enums\SemesterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdatePeriodRequest  extends FormRequest
{
  /**
   * determine if user is authorized to make this request
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * get validation rules for the request
   * 
   * @return array<string, mixed>
   */
  public function rules(): array
  {
    return [
      'year' => ['required', 'integer', 'min:2000', 'max:9999'],
      'semester' => [
        'required',
        new Enum(SemesterType::class),
        Rule::unique('periods')->where(function ($query) {
          return $query->where('year', $this->year);
        })->ignore($this->period->id)
      ]
    ];
  }
}
