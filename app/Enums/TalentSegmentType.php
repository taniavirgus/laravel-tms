<?php

namespace App\Enums;

enum TalentSegmentType: string
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
   * Get the color for the talent segment.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::POTENTIAL_GEM => 'bg-yellow-500',
      self::HIGH_POTENTIAL => 'bg-yellow-600',
      self::STAR => 'bg-yellow-700',
      self::INCONSISTENT_PLAYER => 'bg-blue-500',
      self::CORE_PLAYER => 'bg-blue-600',
      self::HIGH_PERFORMER => 'bg-blue-700',
      self::UNDER_PERFORMER => 'bg-red-500',
      self::AVERAGE_PERFORMER => 'bg-red-600',
      self::SOLID_PERFORMER => 'bg-red-700',
    };
  }

  /**
   * Get segment based on potential and performance scores
   */
  public static function getSegment(float $potential, float $performance): self
  {
    $potentialLevel = match(true) {
      $potential >= 80 => 'high',
      $potential >= 60 => 'moderate',
      default => 'low'
    };

    $performanceLevel = match(true) {
      $performance >= 80 => 'high',
      $performance >= 60 => 'moderate',
      default => 'low'
    };

    return match("$potentialLevel-$performanceLevel") {
      'high-low' => self::POTENTIAL_GEM,
      'high-moderate' => self::HIGH_POTENTIAL,
      'high-high' => self::STAR,
      'moderate-low' => self::INCONSISTENT_PLAYER,
      'moderate-moderate' => self::CORE_PLAYER,
      'moderate-high' => self::HIGH_PERFORMER,
      'low-low' => self::UNDER_PERFORMER,
      'low-moderate' => self::AVERAGE_PERFORMER,
      'low-high' => self::SOLID_PERFORMER,
    };
  }
} 