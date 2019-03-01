<?php

include_once ('includes/application_top.php');

if (AFTERSHIP_ENABLED == 'true') {
  AfterShip::processWebhook();
}

exit();