<?php

namespace App\Enums;

enum StatusType: string
{
  case ACTIVE = 'active';
  case INACTIVE = 'inactive';

  /**
   * Get the label for the status type.
   */
  public function label(): string
  {
    return match ($this) {
      self::ACTIVE => 'Active',
      self::INACTIVE => 'Inactive',
    };
  }

  /**
   * Get the description for the status type.
   */
  public function description(): string
  {
    return match ($this) {
      self::ACTIVE => 'Active',
      self::INACTIVE => 'Inactive',
    };
  }

  /**
   * Get the color for the status type.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::ACTIVE => 'bg-green-500',
      self::INACTIVE => 'bg-red-500',
    };
  }
}
