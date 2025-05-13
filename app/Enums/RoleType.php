<?php

namespace App\Enums;

enum RoleType: string
{
  case SYSADMIN = 'sysadmin';
  case MANAGER = 'manager';
  case SUPERVISOR = 'supervisor';
  case PD = 'people-development';

  /**
   * Get the label for the role type.
   */
  public function label(): string
  {
    return match ($this) {
      self::SYSADMIN => 'System Administrator',
      self::MANAGER => 'Manager',
      self::SUPERVISOR => 'Supervisor',
      self::PD => 'People Development',
    };
  }

  /**
   * Get the description for the role type.
   */
  public function description(): string
  {
    return match ($this) {
      self::SYSADMIN => 'System Administrator',
      self::MANAGER => 'Manager',
      self::SUPERVISOR => 'Supervisor',
      self::PD => 'People Development',
    };
  }

  /**
   * Get the color for the role type.
   * 
   * @return string tailwind color class
   */
  public function color(): string
  {
    return match ($this) {
      self::SYSADMIN => 'indigo',
      self::MANAGER => 'emerald',
      self::SUPERVISOR => 'emerald',
      self::PD => 'blue',
    };
  }

  /**
   * Get the icon for the role type.
   * 
   * @return string lucide icon name
   */
  public function icon(): string
  {
    return match ($this) {
      self::SYSADMIN => 'shield',
      self::MANAGER => 'users-round',
      self::SUPERVISOR => 'users-round',
      self::PD => 'heart-handshake',
    };
  }

  /**
   * Check if the role has the given permission to view dashboard menus.
   * 
   * @params string $menu
   * @return bool
   */
  public function permitted(string $menu): bool
  {
    switch ($this) {
      case self::SYSADMIN:
        return in_array($menu, [
          'users',
          'account',
          'employees',
          'positions',
          'departments',
        ]);

      case self::MANAGER:
      case self::SUPERVISOR:
        return in_array($menu, [
          'account',
          'trainings',
          'employees',
          'evaluations',
          'developments',
        ]);

      case self::PD:
        return in_array($menu, [
          'account',
          'trainings',
          'employees',
          'evaluations',
          'developments',
        ]);

      default:
        return false;
    }
  }
}
