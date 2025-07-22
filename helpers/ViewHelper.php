<?php

function currencyFormat($number)
{
  return number_format($number, 0, ',', '.');
}