<?php
require_once './models/User.php';

function login($username, $password)
{
  $userModel = new User();
  $user = $userModel->getByUserAndPass($username, $password);
  if (!$user)
    return false;

  $_SESSION['user_id'] = $user['id'];
  return true;
}

function logout()
{
  unset($_SESSION['user_id']);
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

function checkLogin()
{
  if (!isset($_SESSION['user_id']))
    return header('Location: /login');

  $userModel = new User();
  $userId = $_SESSION['user_id'];
  $user = $userModel->getById($userId);
  if (!$user)
    return header('Location: /login');
}