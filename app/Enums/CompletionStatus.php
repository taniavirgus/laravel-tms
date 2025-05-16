<?php

namespace App\Enums;

enum CompletionStatus: string
{
  case UPCOMING = 'upcoming';
  case COMPLETED = 'completed';
  case ONGOING = 'ongoing';
  case FINALIZED = 'finalized';

  /**
   * Get the status label.
   *
   * @return string
   */
  public function label(): string
  {
    return match ($this) {
      self::UPCOMING => 'Upcoming',
      self::COMPLETED => 'Completed',
      self::ONGOING => 'Ongoing',
      self::FINALIZED => 'Finalized',
    };
  }

  /**
   * Get the status color.
   *
   * @return string
   */
  public function color(): string
  {
    return match ($this) {
      self::UPCOMING => 'bg-indigo-500',
      self::COMPLETED => 'bg-green-500',
      self::ONGOING => 'bg-yellow-500',
      self::FINALIZED => 'bg-red-500',
    };
  }
}
