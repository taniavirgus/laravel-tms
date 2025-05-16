<?php

namespace App\Enums;

enum BooleanType: string
{
  case YES = 'yes';
  case NO = 'no';

  /**
   * Get the label for the boolean type.
   */
  public function label(): string
  {
    return match ($this) {
      self::YES => 'Yes',
      self::NO => 'No',
    };
  }

  /**
   * Get the color for the boolean type.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::YES => 'bg-green-500',
      self::NO => 'bg-red-500',
    };
  }
}
