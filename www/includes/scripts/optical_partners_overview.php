<?php

use \App\OpticalPartners\OpticalPartners as OP;
ConnectedBrands::useMain();

foreach ($stores = OP::getAllStores(true) as $k => $v) {
  $stores[$k]['id'] = $k;
  $stores[$k]['active'] = false;
  $stores[$k]['location'] = explode(',', $stores[$k]['location']);
}

$smarty->assign('stores', array_values($stores));
$smarty->display('optical_partners/overview.tpl');