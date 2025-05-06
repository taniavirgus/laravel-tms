<?php

namespace App\Enums;

enum LevelType: string
{
  case JUNIOR = 'junior';
  case SENIOR = 'senior';
  case EXPERT = 'expert';

  /**
   * Get the label for the level type.
   */
  public function label(): string
  {
    return match ($this) {
      self::JUNIOR => 'Junior',
      self::SENIOR => 'Senior',
      self::EXPERT => 'Expert',
    };
  }

  /**
   * Get the description for the level type.
   */
  public function description(): string
  {
    return match ($this) {
      self::JUNIOR => 'Junior',
      self::SENIOR => 'Senior',
      self::EXPERT => 'Expert',
    };
  }

  /**
   * Get the color for the level type.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::JUNIOR => 'red',
      self::SENIOR => 'yellow',
      self::EXPERT => 'green',
    };
  }

  /**
   * Get the icon for the level type.
   * 
   * @return string lucide icon name
   */
  public function icon(): string
  {
    return match ($this) {
      self::JUNIOR => 'atom',
      self::SENIOR => 'star',
      self::EXPERT => 'brain',
    };
  }
}
