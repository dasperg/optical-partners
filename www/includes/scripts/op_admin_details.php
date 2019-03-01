<?php

use App\OpticalPartners\OpticalPartners as OP;

OP::checkCredentials();

$storeId = $_SESSION[OP::SESSION_STORE];
$partnerId = OP::tracePartner($storeId, 'store');
$partner = new OP($partnerId);

$smarty->assign([
  'partner_navigation' => true,
  'storeId' => $storeId,
  'partner' => $partner,
  'pageTitle' => 'OP_FE_ADMIN_DETAILS',
]);

$smarty->display('optical_partners/admin/details/index.tpl');