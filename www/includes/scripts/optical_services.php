<?php

use App\OpticalPartners\OpticalPartners as OP;

$language = get_current_language_id();
$services = [];

foreach ($res = OP::getPredefinedServices() as $k => $v) {
  $services[$k]['name'] = $res[$k][$language];
  $services[$k]['description'] = t($k . '_INFO');
}

$smarty->assign('services', $services);
$smarty->display('optical_partners/optical_services.tpl');