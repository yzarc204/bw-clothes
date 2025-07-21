<?php
require_once './models/User.php';

function login($username, $password)
{
  $userModel = new User();
  $user = $userModel->getByUserAndPass($username, $password);
  return $user;
}

function getUser()
{
}