<?php

use App\OpticalPartners\OpticalPartners as OP;

OP::checkCredentials();
$storeId = $_SESSION[OP::SESSION_STORE];
$orders = $periods = [];
$breadcrumbs = [
  [
    'title' => 'OP_FE_ADMIN_ACCOUNTING',
    'link' => '',
  ],
];

switch (OP::getAction()) {
    case 'detail':
        $orders = OP::getAccountingOrders($storeId);
        $breadcrumbs[] = [
          'title' => $_REQUEST['period'],
          'link' => 'action=detail&period='.$_REQUEST['period']
        ];
        $template = 'orders.tpl';
    break;

    case 'list':
    default:
        $periods = OP::getAccountingPeriods($storeId);
        $template = 'index.tpl';
}

$smarty->assign([
  'partner_navigation' => true,
  'periods' => $periods,
  'orders' => $orders,
  'paginationLinks' => $orders['paginationLinks'],
  'breadcrumbs' => $breadcrumbs,
  'pageTitle' => end($breadcrumbs)['title'],
]);

$smarty->display('optical_partners/admin/accounting/'.$template);