<?php

require_once 'app.php';
require_once 'router.php';

$app = new App();
$app->setRoutes($routes);
$app->resolveRouter();
