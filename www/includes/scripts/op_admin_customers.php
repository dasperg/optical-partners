<?php

use App\OpticalPartners\OpticalPartners as OP;

OP::checkCredentials();

$entity = OP::getEntity();
$id = OP::getId($entity);
$languageId = get_current_language_id();
$storeId = $_SESSION[OP::SESSION_STORE];
$breadcrumbs = [];

switch ($_REQUEST['action']) {

    case 'assign':

        OP::takeOverCustomer($id);
        break;

    case 'makeOrder':

        if (!empty($_REQUEST['customer']) && !empty($customer = \customer::getCustomers($_REQUEST['customer']))) {
            reset($customer);
            $data = $customer[key($customer)];

            $check = ['entry_firstname', 'entry_lastname', 'entry_street_address', 'entry_postcode', 'entry_city', 'entry_country_id'];

            foreach ($check as $k => $v) {
                if (empty($data[$v])) {
                    \messageStack::addSession(t('OP_CUSTOMER_MSG_ORDER_NO_ADDRESS'), \messageStack::TYPE_ERROR);
                    tep_redirect(tep_href_link('op_admin_customers.php', 'action=createAddressForm&customer=' . $_REQUEST['customer'], 'SSL'));
                }
            }

            OP::buyAsCustomerSession($_REQUEST['customer']);
            \messageStack::addSession(t('OP_MSG_ORDER_ON_BEHALF_INFO') . $data['customers_firstname'] . ' ' . $data['customers_lastname'], \messageStack::TYPE_NOTICE);
            tep_redirect(tep_href_link('home.php', '', 'SSL'));
        }

        break;

    case 'createAddressForm':
        if (!empty($_REQUEST['customer']) && !empty($customer = \customer::getCustomers($_REQUEST['customer']))) {
            reset($customer);
            $smarty->assign('address', $customer[key($customer)]);
        }
        break;

    case 'createAddressSave':
        if (!empty($_REQUEST['customers_id']) && !empty(\customer::getCustomers($_REQUEST['customers_id']))) {
            OP::createEntity(0, 'address');
            \messageStack::addSession(t('OP_CUSTOMER_ADDRESS_MSG_SUCESS'), \messageStack::TYPE_SUCCESS);
            tep_redirect(tep_href_link('op_admin_customers.php', '', 'SSL'));
        }
        break;


}

switch ($_REQUEST['section']) {

    case 'detail':
        $data['customersInfo'] = customer::getCustomerInfoById($id);
        $data['customersAddress'] = customer::getShippingAddress($id);
        $breadcrumbs[] = [
          'title' => 'OP_CUSTOMER_MENU_DETAILS',
        ];
        $template = 'detail.tpl';
        break;

    case 'orders':
        $pagination = \App\Shared\Utils\Pagination::fromQuery(OP::getOrders($storeId, $id))
          ->perPage(OP_RECORDS_PER_PAGE)
          ->get('db_get_assoc_key');
        $data['orders'] = $pagination->data;
        $data['paginationLinks'] = $pagination->links($smarty);
        $breadcrumbs[] = [
          'title' => 'OP_CUSTOMER_MENU_ORDERS',
        ];
        $template = 'orders.tpl';
        break;

    case 'orderDetail':
        $data['order'] = new order($_REQUEST['order']);
        $breadcrumbs = [
          [
            'title' => 'OP_CUSTOMER_MENU_ORDERS',
            'link' => 'section=orders&entity=customer&customer='.$id,
          ],
          [
            'title' => '#'.$data['order']->id,
          ],
        ];
        $template = 'order_detail.tpl';
        break;

    case 'measurements':
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'create') {
            OP::createEntity($id, 'measurement');
        }
        $services = OP::getStoresServices($storeId);
        foreach ($services as $k => $v) {
            $services[$k]['name'] = $services[$k]['description']['name'][$languageId]['content'];
            unset($services[$k]['description']);
        }
        $data['measurements'] = OP::getCustomerMeasurements($id);
        $data['measurementTypes'] = OP::$measurementTypes;
        $data['services'] = $services;
        $data['contacts'] = OP::getStoresContacts($storeId);
        $breadcrumbs[] = [
          'title' => 'OP_CUSTOMER_MENU_MEASUREMENTS',
        ];
        $template = 'measurements.tpl';
        break;

    case 'measurementDetail':
        $measurement = OP::getMeasurement($_GET['measurement']);
        $data['measurement'] = $measurement;
        $breadcrumbs = [
          [
            'title' => 'OP_CUSTOMER_MENU_MEASUREMENTS',
            'link' => 'section=measurements&entity=customer&customer='.$id,
          ],
          [
            'title' => date('d.m.Y', strtotime($data['measurement']['created_at'])),
          ],
        ];
        $template = 'measurement_detail.tpl';
        break;

    case 'bookingCreate':
        $services = OP::getStoresServices($storeId);
        foreach ($services as $k => $v) {
            $services[$k]['name'] = $v['description']['name'][$languageId]['content'];
            unset($services[$k]['description']);
        }

        $unOrganizedHours = OP::getStoresHours($storeId, false);

        $breadcrumbs = [
          [
            'title' => 'OP_CUSTOMER_BOOKING_CREATE',
          ],
        ];
        if (isset($_REQUEST['booking'])) {
            $data['booking'] = OP::getBooking($_REQUEST['booking']);
        }
        $data['services'] = json_encode($services);
        $data['hoursStartsAt'] = count($unOrganizedHours) ? min(array_column($unOrganizedHours, 'starts_at')) : null;
        $data['hoursEndsAt'] = count($unOrganizedHours) ? max(array_column($unOrganizedHours, 'ends_at')) : null;
        $template = 'booking_create.tpl';
        break;

    default:
        //TODO: exclude resellers
        if (isset($_REQUEST['brand_customers'])) {  // Search for all customers on brand (connected brands are not included)
            // Search customers with address book
            $sql = 'SELECT ab.*, c.* 
                    FROM customers c 
                    JOIN address_book ab
                        ON ab.customers_id = c.customers_id
                        AND ab.address_book_id = c.customers_default_address_id
                    WHERE c.is_guest = 0
                        AND c.customers_firstname = "'.db_input($_REQUEST['search']['c.customers_firstname']).'" 
                        AND c.customers_lastname = "'.db_input($_REQUEST['search']['c.customers_lastname']).'" 
                        AND ab.entry_city = "'.db_input($_REQUEST['search']['ab.entry_city']).'"';
            $customersWithAddressBook = db_get_assoc_arrays($sql);

            // Search all other customers without default address book
            $sql = 'SELECT ab.*, c.* 
                    FROM customers c 
                    LEFT JOIN address_book ab
                        USING(customers_id)
                    WHERE c.is_guest = 0
                        AND c.customers_firstname = "'.db_input($_REQUEST['search']['c.customers_firstname']).'" 
                        AND c.customers_lastname = "'.db_input($_REQUEST['search']['c.customers_lastname']).'"
                        AND ab.customers_id IS NULL';
            $customersWithoutAddressBook = db_get_assoc_arrays($sql);

            // Merge customers
            $customers = array_merge($customersWithAddressBook, $customersWithoutAddressBook);
        } else { // Search or get store customers
            $onlyActiveAssignment = (isset($_GET['all'])) ? false : true; // 'all' means all customers, which are, or were assigned to this store
            $customers = OP::getStoresCustomers($storeId, $onlyActiveAssignment);
        }

        foreach ($customers as &$customer) {
            $sql = 'SELECT ps.id
                    FROM '.OP::$schema['customer']['table'].' sc 
                    LEFT JOIN '.OP::$schema['store']['table'].' ps 
                        ON ps.id = sc.op_stores_id 
                    WHERE customers_id = '.db_input($customer['customers_id']).' 
                        AND sc.ends_at IS NULL
                        AND sc.deleted_at IS NULL';
            $customer['stores'] = db_get_single_values_array($sql);
        }
        $data['customers'] = $customers;
        $template = 'index.tpl';
}

$data['customer'] = OP::getCustomer($id);
$data['submenu'] = [
  [
    'title' => 'OP_CUSTOMER_MENU_DETAILS',
    'link' => 'section=detail&entity=customer&customer='.$data['customer']['customers_id'],
    'activeSection' => ['detail'],
  ],
  [
    'title' => 'OP_CUSTOMER_MENU_ORDERS',
    'link' => 'section=orders&entity=customer&customer='.$data['customer']['customers_id'],
    'activeSection' => ['orders', 'orderDetail'],
  ],
  [
    'title' => 'OP_CUSTOMER_BOOKING_CREATE',
    'link' => 'section=bookingCreate&entity=customer&customer='.$data['customer']['customers_id'],
    'activeSection' => ['bookingCreate'],
  ],
  [
    'title' => 'OP_CUSTOMER_MENU_MEASUREMENTS',
    'link' => 'section=measurements&entity=customer&customer='.$data['customer']['customers_id'],
    'activeSection' => ['measurements', 'measurementDetail'],
  ],
];
$data['breadcrumbs'][] = [
  'title' => 'OP_FE_ADMIN_MY_CUSTOMERS',
  'link' => '',
];
if ($data['customer']) {
    $data['breadcrumbs'][] = [
      'title' => $data['customer']['name'],
      'link' => 'section=detail&entity=customer&customer='.$id,
    ];
}
$data['breadcrumbs'] = array_merge(
  $data['breadcrumbs'],
  $breadcrumbs
);
$data['partner_navigation'] = true; // Display optical partners header
$data['pageTitle'] = end($breadcrumbs)['title'];
$data['storeId'] = $storeId;

$smarty->assign($data);
$smarty->display('optical_partners/admin/customers/'.$template);