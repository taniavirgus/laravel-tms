<?php

namespace App\Enums;

enum GenderType: string
{
  case MALE = 'male';
  case FEMALE = 'female';
  case OTHER = 'other';

  /**
   * Get the label for the gender type.
   */
  public function label(): string
  {
    return match ($this) {
      self::MALE => 'Male',
      self::FEMALE => 'Female',
      self::OTHER => 'Other',
    };
  }

  /**
   * Get the description for the gender type.
   */
  public function description(): string
  {
    return match ($this) {
      self::MALE => 'Male',
      self::FEMALE => 'Female',
      self::OTHER => 'Other',
    };
  }

  /**
   * Get the color for the gender type.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::MALE => 'red',
      self::FEMALE => 'green',
      self::OTHER => 'yellow',
    };
  }
}
