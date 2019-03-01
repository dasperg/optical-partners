<?php
require_once(__DIR__.'/cron_config.php');

use App\OpticalPartners\OpticalPartners as OP;

// Important: CRON needs to run exactly once an hour, otherwise some queries will produce wrong results


/********** TAKE OVER **********/

$sql = '
  SELECT sc.id
  FROM ' . OP::$schema['customer']['table']. ' sc
  LEFT JOIN op_customers_measurements cm
    ON sc.op_stores_id = cm.op_stores_id
    AND sc.customers_id = cm.customers_id
  WHERE cm.deleted_at IS NULL
    AND cm.op_stores_id IS NULL
    AND sc.deleted_at IS NULL
    AND sc.ends_at IS NULL
    AND sc.starts_at < DATE_SUB(NOW(), INTERVAL ' . OP_TAKE_OVER_PERIOD . ' DAY)';

foreach (db_get_single_values_array($sql) as $id) {
  db_update(OP::$schema['customer']['table'], ['deleted_at' => 'now()'], 'id = ' . db_input($id));
}


/********** BOOKING REMINDER  **********/

$sql = '
  SELECT id
  FROM ' . OP::$schema['booking']['table'] . '
  WHERE
    starts_at BETWEEN DATE_ADD(NOW(), INTERVAL 23 HOUR) AND DATE_ADD(NOW(), INTERVAL 24 HOUR)
    AND deleted_at IS NULL
    AND cancelled_at IS NULL';

foreach (db_get_single_values_array($sql) as $id) {
  OP::sendNotification($id, 'booking', 'remind');
}


/********** FITTING REMINDER  **********/

$sql = '
  SELECT id
  FROM ' . OP::$schema['measurement']['table'] . '
  WHERE
    HOUR(NOW()) = 14
    AND deleted_at IS NULL
    AND created_at IS NOT NULL
    AND DATEDIFF(CURDATE(), created_at) = ' . OP_FITTING_REMINDER;

foreach (db_get_single_values_array($sql) as $id) {
  OP::sendNotification($id, 'service', 'remind');
}


/********** PACKAGE REMINDER 1  **********/

foreach (packageCheck(0, 7) as $id) {
  OP::sendNotification($id, 'package', 'remind_1');
}


/********** PACKAGE REMINDER 2  **********/

foreach (packageCheck(1, 10) as $id) {
  OP::sendNotification($id, 'package', 'remind_2');
}


/********** PACKAGE CANCELLATION  **********/

foreach (packageCheck(2, 14) as $id) {
  OP::setPackageStatus($id, OP::PACKAGE_STATUS_CANCELLED);
}


function packageCheck($reminders, $days) {

  $sql = '
    SELECT sp.id
    FROM ' . OP::$schema['package']['table'] . ' sp
    JOIN ' . OP::$schema['history']['table'] . ' h
      ON  h.entity_id = sp.id
      AND h.entity_type = "package"
      AND h.field = "status"
      AND h.value = "OP_PACKAGE_READY_FOR_PICKUP"
      AND h.created_at IS NOT NULL
    WHERE
      HOUR(NOW()) = 14
      AND sp.deleted_at IS NULL
      AND sp.aftership_id IS NOT NULL
      AND sp.status = "OP_PACKAGE_READY_FOR_PICKUP"
      AND sp.reminders = ' . $reminders . '
      AND DATEDIFF(CURDATE(), h.created_at) = ' . $days;

  return db_get_single_values_array($sql);

}