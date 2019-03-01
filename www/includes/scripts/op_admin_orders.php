<?php

use App\OpticalPartners\OpticalPartners as OP;
//dd($_REQUEST);
OP::checkCredentials();

$storeId = $_SESSION[OP::SESSION_STORE];
$summary = [];
$breadcrumbs = [
  [
    'title' => 'OP_FE_ADMIN_ORDERS',
    'link' => '',
  ],
];

switch (OP::getAction()) {
    case 'update':
        $entity = OP::getEntity();
        $id = OP::getId($entity);   // 'package'
        OP::checkIntegrity($id, $entity);
        if (!empty($_GET['status'])) {
            OP::setPackageStatus($id, $_GET['status']);
        }

        tep_redirect(tep_href_link('op_admin_orders.php', '', 'SSL'));
    break;
    case 'detail':
        $id = OP::getId('orders_id');
        $query = OP::searchOrderById($id);
    break;
    default:
        $query = OP::getOrders($storeId);
    break;
}

$pagination = \App\Shared\Utils\Pagination::fromQuery($query)
  ->perPage(OP_RECORDS_PER_PAGE)
  ->get('db_get_assoc_key');
foreach ($pagination->data as $orderId => &$order) {
    $order['packages'] = OP::getOrderPackageInfo($orderId);
}

$smarty->assign([
  'orders' => $pagination->data,
  'paginationLinks' => $pagination->links($smarty),
  'summary' => $summary,
  'partner_navigation' => true,
  'breadcrumbs' => $breadcrumbs,
  'pageTitle' => end($breadcrumbs)['title'],
]);

$smarty->display('optical_partners/admin/orders/index.tpl');