<?php

/**
 * Format tiền Việt Nam
 * @param float $number Số tiền cần format
 * @return string
 */
function currencyFormat(float $number): string
{
  return number_format($number, 0, ',', '.');
}