<?php

use App\OpticalPartners\OpticalPartners as OP;

if (!customer::$customer_id) {
  die(json_encode(null));
}

if (!empty($_REQUEST['store_id'])) {
  $storeId = $_REQUEST['store_id'];

  $startsAt = $date = (!empty($_REQUEST['starts_at'])) ? $_REQUEST['starts_at'] : null;
  $days = (!empty($_REQUEST['days'])) ? $_REQUEST['days'] : 7;
  $unOrganizedHours = OP::getStoresHours($storeId, false);
  $bookings = OP::getStoreBookings($storeId, $startsAt, $days);

  if (isset($_SESSION[OP::SESSION_STORE]) && count($bookings)) {
    foreach ($bookings as $day => $items) {
      foreach ($items as $k => $v) {
        $bookings[$day][$k]['customer'] = OP::getCustomer($bookings[$day][$k]['customers_id']);
      }
    }
  }

  $res = [
    'customer_id' => (isset($_GET['customer'])) ? $_GET['customer'] : customer::$customer_id,  // for mark as "my bookings" - not used yet
    'bookings' => $bookings,
    'hours' => OP::getStoresHours($storeId),
    'hoursStartsAt' => (count($unOrganizedHours)) ? min(array_column($unOrganizedHours, 'starts_at')) : null,
    'hoursEndsAt' => (count($unOrganizedHours)) ? max(array_column($unOrganizedHours, 'ends_at')) : null,
  ];

  // Edit existing booking
  if (isset($_REQUEST['booking'])) {
      $res['booking'] = OP::getBooking($_REQUEST['booking']);
      if (isset($res['bookings'][date("Y-m-d", strtotime($res['booking']['starts_at']))])) {
          unset($res['bookings'][date("Y-m-d", strtotime($res['booking']['starts_at']))][$res['booking']['id']]);
      }
  }

  die(json_encode($res));
}
