<?php

namespace App\Enums;

enum TrainingType: string
{
  case OPTIONAL = 'optional';
  case MANDATORY = 'mandatory';

  /**
   * Get the label for the training type.
   */
  public function label(): string
  {
    return match ($this) {
      self::OPTIONAL => 'Optional',
      self::MANDATORY => 'Mandatory',
    };
  }

  /**
   * Get the description for the training type.
   */
  public function description(): string
  {
    return match ($this) {
      self::OPTIONAL => 'Optional training',
      self::MANDATORY => 'Mandatory training',
    };
  }

  /**
   * Get the color for the approval type.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::OPTIONAL => 'bg-yellow-500',
      self::MANDATORY => 'bg-green-500',
    };
  }
}
