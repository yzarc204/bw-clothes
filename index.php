<?php
require_once 'app.php';
require_once 'router.php';

session_start();

$app = new App();
$app->addRoutes($routes);
$app->addRoutes($adminRoutes);
$app->resolveRouter();
