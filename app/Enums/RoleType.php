<?php

namespace App\Enums;

enum RoleType: string
{
  case SYSADMIN = 'sysadmin';
  case MANAGER = 'manager';
  case SUPERVISOR = 'supervisor';
  case PD = 'people-development';

  public function label(): string
  {
    return match ($this) {
      self::SYSADMIN => 'System Administrator',
      self::MANAGER => 'Manager',
      self::SUPERVISOR => 'Supervisor',
      self::PD => 'People Development',
    };
  }

  public function description(): string
  {
    return match ($this) {
      self::SYSADMIN => 'System Administrator',
      self::MANAGER => 'Manager',
      self::SUPERVISOR => 'Supervisor',
      self::PD => 'People Development',
    };
  }

  public function color(): string
  {
    return match ($this) {
      self::SYSADMIN => 'bg-indigo-500',
      self::MANAGER => 'bg-emerald-500',
      self::SUPERVISOR => 'bg-emerald-500',
      self::PD => 'bg-blue-500',
    };
  }
}
