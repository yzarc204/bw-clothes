<?php

/**
 * Format tiền Việt Nam
 * @param float $number Số tiền cần format
 * @return string
 */
function currencyFormat(float $number): string
{
  return number_format($number, 0, ',', '.');
}

function pagination($pagination, $view)
{
  $onFirstPage = $pagination['page'] == 1;
  $onLastPage = $pagination['page'] == $pagination['total_pages'];

  $baseUrl = '/' . $_GET['url'];
  $params = $_GET;
  unset($params['url']);

  $nextPageParams = array_merge($params, ['page' => $pagination['page'] + 1]);
  $nextPageUrl = $baseUrl . '?' . http_build_query($nextPageParams);

  $prevPageParams = array_merge($params, ['page' => $pagination['page'] - 1]);
  $prevPageUrl = $baseUrl . '?' . http_build_query($prevPageParams);

  $urls = [];
  for ($page = $pagination['page'] - 2; $page <= $pagination['page'] + 2; $page++) {
    if ($page < 1 || $page > $pagination['total_pages'])
      continue;

    $baseUrl = '/' . $_GET['url'];
    $params = array_merge($params, ['page' => $page]);
    $url = $baseUrl .= '?' . http_build_query($params);

    $urls[] = [
      'page' => $page,
      'url' => $url
    ];
  }

  require $view;
}

function adminltePagination($pagination)
{
  pagination($pagination, './views/layouts/adminlte/pagination.php');
}