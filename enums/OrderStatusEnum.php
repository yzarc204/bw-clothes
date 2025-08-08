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

  public static function getColor($status)
  {
    switch ($status) {
      case self::PENDING:
        return 'warning';
      case self::PROCESSING:
        return 'info';
      case self::DELIVERING:
        return 'primary';
      case self::RECEIVED:
        return 'success';
      case self::CANCELED:
        return 'danger';
    }
  }
}