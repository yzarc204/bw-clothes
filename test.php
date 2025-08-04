<?php
function dequy($arr, $totalCase, $indexes = [], $result = [])
{
  // Nếu đã gộp xong toàn bộ tổ hợp thì return về kết quả
  if (count($result) >= $totalCase) {
    return $result;
  }

  // Tạo mảng chứa index của từng mảng con trong mảng lớn $arr
  if (count($indexes) === 0) {
    for ($i = 0; $i < count($arr); $i++) {
      $indexes[] = count($arr[$i]) - 1;
    }
  }

  $values = [];
  for ($i = count($arr) - 1; $i >= 0; $i--) {
    $vIndex = $indexes[$i];
    $values[] = $arr[$i][$vIndex];
    if ($indexes[$i] <= 0) { // Nếu đã duyệt hết mảng thì reset index lại về ban đầu
      $indexes[$i] = count($arr[$i]) - 1;
    } else {
      $indexes[$i]--; // Nếu chưa duyệt hết mảng thì chuyển index về phần tử đứng trước phần tử hiện tại
    }
  }

  $result[] = implode(' - ', $values);

  return dequy($arr, $totalCase, $indexes, $result);
}

function countTotalCase($arr)
{
  $total = 1;
  foreach ($arr as $a) {
    $total *= count($a);
  }
  return $total;
}

$attributes = [
  [1, 2],
  ['a', 'b', 'c'],
  ['x', 'y', 'z']
];
$result = dequy($attributes, countTotalCase($attributes));
print_r($result);