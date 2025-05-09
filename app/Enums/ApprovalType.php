<?php

namespace App\Enums;

enum ApprovalType: string
{
  case DRAFT = 'draft';
  case APPROVED = 'approved';
  case REJECTED = 'rejected';

  /**
   * Get the label for the approval type.
   */
  public function label(): string
  {
    return match ($this) {
      self::DRAFT => 'Draft',
      self::APPROVED => 'Approved',
      self::REJECTED => 'Rejected',
    };
  }

  /**
   * Get the description for the approval type.
   */
  public function description(): string
  {
    return match ($this) {
      self::DRAFT => 'Draft',
      self::APPROVED => 'Approved',
      self::REJECTED => 'Rejected',
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
      self::DRAFT => 'base',
      self::APPROVED => 'green',
      self::REJECTED => 'red',
    };
  }
}
