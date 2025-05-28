<?php

namespace App\Enums;

enum SegmentType: string
{
  case POTENTIAL_GEM = 'potential-gem';
  case HIGH_POTENTIAL = 'high-potential';
  case STAR = 'star';
  case INCONSISTENT_PLAYER = 'inconsistent-player';
  case CORE_PLAYER = 'core-player';
  case HIGH_PERFORMER = 'high-performer';
  case UNDER_PERFORMER = 'under-performer';
  case AVERAGE_PERFORMER = 'average-performer';
  case SOLID_PERFORMER = 'solid-performer';

  /**
   * Get the label for the talent segment.
   */
  public function label(): string
  {
    return match ($this) {
      self::POTENTIAL_GEM => 'Potential Gem',
      self::HIGH_POTENTIAL => 'High Potential',
      self::STAR => 'Star',
      self::INCONSISTENT_PLAYER => 'Inconsistent Player',
      self::CORE_PLAYER => 'Core Player',
      self::HIGH_PERFORMER => 'High Performer',
      self::UNDER_PERFORMER => 'Under Performer',
      self::AVERAGE_PERFORMER => 'Average Performer',
      self::SOLID_PERFORMER => 'Solid Performer',
    };
  }

  /**
   * Get the description for the talent segment.
   */
  public function description(): string
  {
    return match ($this) {
      self::POTENTIAL_GEM => 'High Potential, Low Performance',
      self::HIGH_POTENTIAL => 'High Potential, Moderate Performance',
      self::STAR => 'High Potential, High Performance',
      self::INCONSISTENT_PLAYER => 'Moderate Potential, Low Performance',
      self::CORE_PLAYER => 'Moderate Potential, Moderate Performance',
      self::HIGH_PERFORMER => 'Moderate Potential, High Performance',
      self::UNDER_PERFORMER => 'Low Potential, Low Performance',
      self::AVERAGE_PERFORMER => 'Low Potential, Moderate Performance',
      self::SOLID_PERFORMER => 'Low Potential, High Performance',
    };
  }

  /**
   * Get segment based on potential and performance scores
   */
  public static function getSegment(float $potential, float $performance): self
  {
    $potential = match (true) {
      $potential >= 80 => 'high',
      $potential >= 60 => 'moderate',
      default => 'low'
    };

    $performance = match (true) {
      $performance >= 80 => 'high',
      $performance >= 60 => 'moderate',
      default => 'low'
    };

    $segments = [
      'low' => [
        'low' => self::UNDER_PERFORMER,
        'moderate' => self::AVERAGE_PERFORMER,
        'high' => self::SOLID_PERFORMER
      ],
      'moderate' => [
        'low' => self::INCONSISTENT_PLAYER,
        'moderate' => self::CORE_PLAYER,
        'high' => self::HIGH_PERFORMER
      ],
      'high' => [
        'low' => self::POTENTIAL_GEM,
        'moderate' => self::HIGH_POTENTIAL,
        'high' => self::STAR
      ],
    ];

    return $segments[$potential][$performance];
  }

  /**
   * Get the color for the talent segment.
   */
  public function color(): string
  {
    return match ($this) {
      self::UNDER_PERFORMER => 'bg-red-500',
      self::AVERAGE_PERFORMER => 'bg-yellow-500',
      self::SOLID_PERFORMER => 'bg-green-500',
      self::INCONSISTENT_PLAYER => 'bg-red-500',
      self::CORE_PLAYER => 'bg-yellow-500',
      self::HIGH_PERFORMER => 'bg-green-500',
      self::POTENTIAL_GEM => 'bg-yellow-500',
      self::HIGH_POTENTIAL => 'bg-green-500',
      self::STAR => 'bg-green-500',
    };
  }
}
