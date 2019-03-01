<?php

use App\OpticalPartners\OpticalPartners as OP;

$id = false;

if (!empty($id = $_REQUEST['booking'])) {
    OP::rescheduleBooking($id, 'booking');
} else {
    $id = OP::createEntity($_REQUEST['id'], 'booking');
}

if ($id) {
  $result = OP::getBooking($id);
} else {
  $result = false;
}

die(json_encode($result));