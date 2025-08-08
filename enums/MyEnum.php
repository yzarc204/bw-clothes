<?php

class MyEnum
{
  protected static $enum = [];

  public static function keys()
  {
    return array_keys(static::$enum);
  }

  public static function values()
  {
    return array_values(static::$enum);
  }

  public static function all()
  {
    return static::$enum;
  }

  public static function getValue($key)
  {
    return static::$enum[$key] ?? null;
  }
}