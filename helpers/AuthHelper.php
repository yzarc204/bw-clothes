<?php
require_once './models/User.php';

function login($username, $password)
{
  $userModel = new User();
  $user = $userModel->getByUserAndPass($username, $password);
  return $user ? true : false;
}

function getUser()
{
  $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
  if (!$userId)
    return null;
  $userModel = new User();
  $user = $userModel->getById($userId);
  return $user;
}