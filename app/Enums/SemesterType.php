<?php

namespace App\Enums;

/**
 * represents semester types in the system
 */
enum SemesterType: string
{
  case ODD = 'odd';
  case EVEN = 'even';

  /**
   * get label for the enum value
   */
  public function label(): string
  {
    return match ($this) {
      self::ODD => 'Odd',
      self::EVEN => 'Even',
    };
  }
}
