<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';

class RatingController
{
  public function __construct()
  {
    checkLogin();
  }

  public function create()
  {
  }
}