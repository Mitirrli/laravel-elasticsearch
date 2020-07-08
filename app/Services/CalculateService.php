<?php

namespace App\Services;

class CalculateService
{
  /**
   * Add function.
   */
  public function add(int $num1, int $num2): int
  {
    return $num1 + $num2;
  }

  /**
   * Reduce function.
   */
  public function reduce(int $num1, int $num2): int
  {
    return $num1 - $num2;
  }
}
