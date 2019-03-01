<?php

use App\OpticalPartners\OpticalPartners as OP;

OP::checkCredentials();

$langId = get_current_language_id();
$storeId = $_SESSION[OP::SESSION_STORE];
$section = !empty($_REQUEST['section']) ? $_REQUEST['section'] : null;
$action = !empty($_REQUEST['action']) ? $_REQUEST['action'] : null;
$breadcrumbs = [];

$redirect = '/' . OP::getLanguages()[$langId]['code'] . '/op_admin_bookings.php';
$params = '?section=detail&booking=' . $_GET['booking'];

switch ($action) {

    case 'update':
      OP::updateEntity($_GET['booking'], 'booking');
      messageStack::addSession(t('OP_APPOINTMENT_UPDATE_SUCCESS'), messageStack::TYPE_SUCCESS);
      tep_redirect($redirect . $params);
      break;

    case 'cancel':
      OP::cancelBooking($_GET['booking']);
      messageStack::addSession(t('OP_APPOINTMENT_CANCEL_SUCCESS'), messageStack::TYPE_SUCCESS);
      tep_redirect($redirect);
      break;

    case 'delete':
      OP::deleteEntity($_GET['booking'], 'booking');
      messageStack::addSession(t('OP_APPOINTMENT_DELETE_SUCCESS'), messageStack::TYPE_SUCCESS);
      tep_redirect($redirect);
      break;

    case 'edit':
      OP::getBooking($_GET['booking']);
      break;

}

switch ($section) {

    case 'detail':
      $id = OP::getId('booking');
      $booking = OP::getBooking($id, true);
      $booking['editable'] = ($booking['starts_at'] >= date("Y-m-d H:i:s", strtotime("- " . OP_BOOKING_PAST_PERIOD." days")));
      $booking['upcoming'] = $booking['starts_at'] >= date("Y-m-d H:i:s") ? true : false;
      $data['booking'] = $booking;
      $data['customer'] = OP::getCustomer($booking['customers_id']);
      if ($booking['upcoming']) {
        $breadcrumbs[] = [
          'title' => 'OP_APPOINTMENT_UPCOMING',
          'link' => '',
        ];        
      } else {
        $breadcrumbs[] = [
          'title' => 'OP_APPOINTMENT_PAST',
          'link' => 'section=past',
        ];        
      }
      $breadcrumbs[] = [
          'title' => t('OP_APPOINTMENT') . ' #' . $id,
        ];

      $template = 'detail.tpl';
      break;

    case 'calendar':
      $services = OP::getStoresServices($storeId);
      foreach ($services as $k => $v) {
        $services[$k]['name'] = $v['description']['name'][$langId]['content'];
        unset($services[$k]['description']);
      }

      $unOrganizedHours = OP::getStoresHours($storeId, false);

      $breadcrumbs[] = [
        'title' => 'OP_APPOINTMENT_CALENDAR',
        'link' => 'section=calendar',
      ];
      $data['services'] = json_encode($services);
      $data['admin'] = true;
      $data['wrapper'] = false;
      $data['hoursStartsAt'] = count($unOrganizedHours) ? min(array_column($unOrganizedHours, 'starts_at')) : null;
      $data['hoursEndsAt'] = count($unOrganizedHours) ? max(array_column($unOrganizedHours, 'ends_at')) : null;
      $template = 'calendar.tpl';
      break;

    case 'past':

    default:
      $bookings = OP::getStoreBookings($storeId, null, null, false, ($section == 'past'), true);
      foreach ($bookings as &$booking) {
          $booking['customer'] = OP::getCustomer($booking['customers_id']);
          $booking['editable'] = ($booking['starts_at'] >= date(
              "Y-m-d H:i:s",
              strtotime("- ".OP_BOOKING_PAST_PERIOD." days")
            ));
      }

      $breadcrumbs[] = [
        'title' => ($section == 'past') ? 'OP_APPOINTMENT_PAST' : 'OP_APPOINTMENT_UPCOMING',
        'link' => ($section == 'past') ? 'section=past' : '',
      ];
      $data['bookings'] = $bookings;
      $template = 'index.tpl';
}

$data['submenu'] = [
  [
    'title' => 'OP_APPOINTMENT_UPCOMING',
    'link' => '',
    'activeSection' => [''],
  ],
  [
    'title' => 'OP_APPOINTMENT_PAST',
    'link' => 'section=past',
    'activeSection' => ['past'],
  ],
];

$data['breadcrumbs'] = array_merge(
  [
    [
      'title' => 'OP_FE_ADMIN_BOOKING',
      'link' => '',
    ],
  ],
  $breadcrumbs
);

$data['partner_navigation'] = true;
$data['pageTitle'] = end($breadcrumbs)['title'];

$smarty->assign($data);
$smarty->display('optical_partners/admin/bookings/'.$template);