<?php

use App\OpticalPartners\OpticalPartners as OP;

if ((bool) $_SESSION['is_guest']) {
  customer::guestLogout();
}

Security::CheckCustomerLoggedIn();
ConnectedBrands::usePrimary();

$account = customer::getCustomers(customer::$customer_id, $_SESSION['customer_email'], true)[0];

$entity = OP::getEntity();
$action = OP::getAction();
$id = OP::getId('id');

if ($action === 'cancel' && !empty($entity) && !empty($id)) {
  OP::cancelBooking($id);
  messageStack::addSession(t('OP_APPOINTMENT_CANCEL_SUCCESS'), messageStack::TYPE_SUCCESS);
  tep_redirect('op_customer_bookings.php');
}


/********** BOOKINGS **********/
$bookings = OP::getCustomerBookings(customer::$customer_id, true);
foreach ($bookings as $k => $v) {
  $store = OP::getStore($v['op_stores_id']);
  $bookings[$k]['partner'] = $store['op_partners_id'];
  $bookings[$k]['store'] = $store['name'];
  $bookings[$k]['duration'] = $store['services'][$v['op_services_id']]['duration'];
}


/********** MEASURMENTS **********/
$measurements = OP::getCustomerMeasurements(customer::$customer_id);

$smarty->assign([
  'account' => $account,
  'bookings' => $bookings,
  'measurements' => $measurements,
]);


$smarty->display('optical_partners/customer/op_customer_bookings.tpl');