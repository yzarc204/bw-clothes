<?php

$routes = [
  '^$' => ['Home', 'index'], // Route gốc: /
  '^product$' => ['Home', 'products'], // Route: /product
  '^search$' => ['Home', 'search'], // Route: /search
  '^product/(\d+)$' => ['Home', 'product'], // Route: /product/123
  '^category/([a-zA-Z0-9-]+)$' => ['Home', 'category'], // Route: /category/abc
];