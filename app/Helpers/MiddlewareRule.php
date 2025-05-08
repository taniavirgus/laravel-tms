<?php

namespace App\Helpers;

use App\Enums\RoleType;

class MiddlewareRule
{
  /**
   * Function to create a middleware rule for a given route.
   * 
   * @param string $alias The alias of the route.
   * @param RoleType $roles The roles that are allowed to access the route.
   * @return string The middleware rule string.
   */
  public static function role(string $alias, RoleType ...$roles): string
  {
    $roles = array_map(fn($role) => $role->value, $roles);
    return $alias . ':' . implode(',', $roles);
  }
}
