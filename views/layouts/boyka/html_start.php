<?php
$loginedUser = getCurrentUser();
$userCart = getUserCart();
$menuCategories = listCategories();
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title><?= isset($pageTitle) ? $pageTitle : 'BW - Cloz' ?></title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/boyka/images/favicon.ico" />

  <!-- CSS ========================= -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/boyka/css/bootstrap.min.css" />

  <!-- Font CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/boyka/css/font-awesome.min.css" />

  <!-- Plugins CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/boyka/css/plugins.css" />

  <!-- Main Style CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/boyka/css/style.css" />

  <!-- Modernizer JS -->
  <script src="<?= BASE_URL ?>/assets/boyka/js/vendor/modernizr-2.8.3.min.js"></script>