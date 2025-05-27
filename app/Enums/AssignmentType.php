<?php

namespace App\Enums;

enum AssignmentType: string
{
  case CLOSED = 'closed';
  case OPEN = 'open';

  /**
   * Get the label for the assignment type.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::CLOSED => 'Department Specific',
      self::OPEN => 'All Departments',
    };
  }

  /**
   * Get the description for the assignment type.
   *
   * @return string
   */
  public function description(): string
  {
    return match ($this) {
      self::CLOSED => 'Assigned to specific departments',
      self::OPEN => 'Assigned to all departments',
    };
  }

  /**
   * Get the color for the assignment type.
   *
   * @return string
   */
  public function color(): string
  {
    return match ($this) {
      self::CLOSED => 'bg-yellow-500',
      self::OPEN => 'bg-primary-500',
    };
  }
}
