<?php

if (!function_exists('array_to_object')) {
  /**
   * Check if an array is associative.
   *
   * @param array $array
   * @return bool
   */
  function is_associative(array $array): bool
  {
    return array_keys($array) !== range(0, count($array) - 1);
  }

  /**
   * Check if an array is multidimensional.
   *
   * @param array $array
   * @return bool
   */
  function is_multidimensional(array $array): bool
  {
    foreach ($array as $value) {
      if (is_array($value)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Recursively convert an array to an object.
   *
   * @param mixed $data
   * @return mixed
   */
  function array_to_object($data): mixed
  {
    $array = is_array($data);
    $object = is_object($data);

    if ($array) {
      $assoc = is_associative($data);
      $multi = is_multidimensional($data);

      if ($assoc || $multi) return (object) array_map('array_to_object', $data);
      return $data;
    }


    if ($object) {
      foreach ($data as $key => $value) {
        $data->$key = array_to_object($value);
      }
    }

    return $data;
  }
}
