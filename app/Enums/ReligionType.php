<?php

namespace App\Enums;

enum ReligionType: string
{
  case ISLAM = 'islam';
  case CHRISTIANITY = 'christianity';
  case JUDAISM = 'judaism';
  case HINDUISM = 'hinduism';
  case BUDDHISM = 'buddhism';
  case OTHER = 'other';

  /**
   * Get the label for the religion type.
   */
  public function label(): string
  {
    return match ($this) {
      self::ISLAM => 'Islam',
      self::CHRISTIANITY => 'Christianity',
      self::JUDAISM => 'Judaism',
      self::HINDUISM => 'Hinduism',
      self::BUDDHISM => 'Buddhism',
      self::OTHER => 'Other',
    };
  }

  /**
   * Get the description for the religion type.
   */
  public function description(): string
  {
    return match ($this) {
      self::ISLAM => 'Islam',
      self::CHRISTIANITY => 'Christianity',
      self::JUDAISM => 'Judaism',
      self::HINDUISM => 'Hinduism',
      self::BUDDHISM => 'Buddhism',
      self::OTHER => 'Other',
    };
  }

  /**
   * Get the color for the religion type.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::ISLAM => 'red',
      self::CHRISTIANITY => 'green',
      self::JUDAISM => 'yellow',
      self::HINDUISM => 'blue',
      self::BUDDHISM => 'purple',
      self::OTHER => 'gray',
    };
  }
}
