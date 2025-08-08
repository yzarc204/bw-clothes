<?php
require_once './enums/MyEnum.php';

class OrderStatusEnum extends MyEnum
{
  const PENDING = 'pending';
  const PROCESSING = 'processing';
  const DELIVERING = 'delivering';
  const RECEIVED = 'received';
  const CANCELED = 'canceled';

  protected static $enum = [
    'pending' => 'chờ xác nhận',
    'processing' => 'đang xử lí',
    'delivering' => 'đang vận chuyển',
    'received' => 'giao hàng thành công',
    'canceled' => 'đã huỷ'
  ];
}