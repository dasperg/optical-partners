<?php

namespace App\OpticalPartners;

use App\Email\CustomerEmail;
use App\Shared\Utils\Pagination;

class OpticalPartners {

  // Sessions
  const SESSION_STORE = 'op_stores_id';
  const SESSION_OP_CUSTOMER = 'op_customer';
  const SESSION_BUY_AS_CUSTOMER = 'buy_as_customer';

  // Package statuses
  const PACKAGE_STATUS_ON_THE_WAY = 'OP_PACKAGE_ON_THE_WAY';
  const PACKAGE_STATUS_READY_FOR_PICKUP = 'OP_PACKAGE_READY_FOR_PICKUP';
  const PACKAGE_STATUS_DELIVERED = 'OP_PACKAGE_DELIVERED';
  const PACKAGE_STATUS_PICKED_UP = 'OP_PACKAGE_PICKED_UP';
  const PACKAGE_STATUS_CANCELLED = 'OP_PACKAGE_CANCELLED';
  const PACKAGE_STATUS_RETURNED = 'OP_PACKAGE_RETURNED';

  // Order statuses
  const ORDER_STATUS_OPEN = 'OP_ORDER_STATUS_OPEN';
  const ORDER_STATUS_CLOSED = 'OP_ORDER_STATUS_CLOSED';

  public static $onBehalfOfCustomerId = null;

  public static $actions = ['list', 'edit', 'create', 'update', 'delete', 'toggle', 'assign', 'detail', 'cancel'];

  public static $schema = [
    'partner' => [
      'parent' => 'partner',
      'table' => 'op_partners',
      'fields' => ['id', 'name', 'status', 'commission_1', 'commission_2', 'commission_3', 'commission_4']
    ],
    'store' => [
      'parent' => 'partner',
      'table' => 'op_partners_stores',
      'fields' => ['id', 'op_partners_id', 'status', 'name', 'image', 'logo', 'website', 'street', 'city', 'zip', 'countries_id', 'location', 'business_id', 'register_name', 'vat_id', 'bank_name', 'bank_account_name', 'bank_account_iban', 'op_stores_contacts_id']
    ],
    'contact' => [
      'parent' => 'store',
      'table' => 'op_stores_contacts',
      'fields' => ['id', 'op_stores_id', 'name', 'phone', 'email', 'private']
    ],
    'hour' => [
      'parent' => 'store',
      'table' => 'op_stores_hours',
      'fields' => ['id', 'op_stores_id', 'weekday', 'starts_at', 'ends_at', 'date_from', 'date_to'],
      'multiple' => 'weekday'
    ],
    'service' => [
      'parent' => 'store',
      'table' => 'op_stores_services',
      'fields' => ['id', 'op_stores_id', 'duration', 'price']
    ],
    'booking' => [
      'parent' => 'store',
      'table' => 'op_stores_bookings',
      'fields' => ['id', 'op_stores_id', 'op_services_id', 'remark', 'customers_id', 'starts_at', 'attended_at', 'cancelled_at']
    ],
    'customer' => [
      'parent' => 'store',
      'table' => 'op_stores_customers',
      'fields' => ['id', 'op_stores_id', 'customers_id', 'starts_at', 'ends_at']
    ],
    'measurement' => [
      'parent' => 'measurement',
      'table' => 'op_customers_measurements',
      'fields' => ['id', 'op_stores_id', 'op_services_id', 'customers_id', 'consultant_name', 'values', 'remark']
    ],
    'order' => [
      'parent' => 'store',
      'table' => 'op_stores_orders',
      'fields' => ['id', 'orders_id', 'on_behalf', 'status', 'order_total', 'commission_calc', 'commission_diff', 'invoice_number', 'issued_at', 'paid_at']
    ],
    'commission' => [
      'parent' => 'store',
      'table' => 'op_stores_commissions',
      'fields' => ['id', 'orders_id', 'op_stores_id', 'orders_products_id', 'group', 'rate', 'amount', 'product_type_id']
    ],
    'address' => [
      'parent' => 'address',
      'table' => 'address_book',
      'fields' => ['customers_id', 'address_book_id', 'entry_firstname', 'entry_lastname', 'entry_country_id', 'entry_gender', 'entry_company', 'entry_street_address', 'entry_postcode', 'entry_city']
    ],
    'package' => [
        'parent' => 'order',
        'table' => 'op_stores_packages',
        'fields' => ['id', 'status', 'op_stores_orders_id', 'orders_id', 'package_id', 'aftership_id', 'reminders']
    ],
    'history' => [
        'parent' => null,
        'table' => 'op_history',
        'fields' => ['id', 'entity_id', 'entity_type', 'field', 'value'],
    ],
  ];

  public static $sections = [
    'store' => ['about', 'control', 'team', 'booking', 'contact'],
    'hour' => ['remark'],
    'service' => ['name'],
  ];

  public static $measurementTypes = ['SPH', 'CYL', 'AXS', 'ADD', 'HSA', 'VCC'];

  public static $images = [
    'store' => ['image', 'logo'],
  ];

  public static $toggles = ['status', 'private'];

  public static $spaceless = ['business_id', 'vat_id', 'zip', 'location', 'bank_iban', 'price'];

  public static $commissionGroups = [
        1 => [
            PRODUCT_TYPE_LENSES_DAILY
        ],
        2 => [
            PRODUCT_TYPE_LENSES,
            PRODUCT_TYPE_LENSES_SINGLE,
            PRODUCT_TYPE_LENS_PATTERN,
            PRODUCT_TYPE_LENSES_TESTER,
            PRODUCT_TYPE_LENSES_COLORED,
            PRODUCT_TYPE_LENSES_TORICS,
            PRODUCT_TYPE_LENSES_BIFOCAL,
            PRODUCT_TYPE_LENSES_2WEEKS,
            PRODUCT_TYPE_LENSES_MONTHLY,
        ],
        3 => [
            PRODUCT_TYPE_ACCESOIRES,
            PRODUCT_TYPE_SOLUTIONS,
            PRODUCT_TYPE_DIETARY_SUPLEMENT_EYE_HARD,
        ]
    ];

  public static $scopes = [
    'store' => [
      'field' => 'op_stores_id',
      'set' => ['order', 'customer', 'booking', 'service', 'measurement'],
    ],
    'customer' => [
      'field' => 'customers_id',
      'set' => ['order', 'booking', 'measurement'],
    ],
    'search' => [
      'field' => 'orders_id',
      'set' => [],
    ],
  ];

  public $info;
  public $stores;
  public $services;

  public function __construct($id) {
    if (self::checkIntegrity($id, 'partner')) {
      self::getPartner($id);
    }
  }

  public function with($parameter) {
      switch($parameter) {
          case 'storeAccounting':
              foreach($this->stores as $storeId => &$store) {
                  $store['accounting'] = array_slice(self::getAccountingPeriods($storeId), 1);
              }
              break;
      }

      return $this;
  }


  /********** TRACING **********/

  public static function traceParent($id, $entity) {
    self::checkIntegrity($id, $entity);
    return $entity == 'store' ? self::tracePartner($id, $entity, false) : self::traceStore($id, $entity, false);
  }

  public static function tracePartner($id, $entity) {
    self::checkIntegrity($id, $entity);
    $sql = 'SELECT op_partners_id FROM ' . self::$schema['store']['table'] . ' WHERE id = ' . ($entity == 'store' ? $id : self::traceStore($id, $entity, false));
    return db_get_single_value($sql);
  }

  public static function traceStore($id, $entity) {
    self::checkIntegrity($id, $entity);
    $sql = 'SELECT op_stores_id FROM ' . self::$schema[$entity]['table'] . ' WHERE id = ' . $id;
    return db_get_single_value($sql);
  }

  public static function createEntity($id, $entity) {

    if (self::$schema[$entity]['parent'] !== $entity) {
      self::checkIntegrity($id, self::$schema[$entity]['parent']);
    }

    $data = self::setFields($entity);
    $data['created_at'] = 'now()';

    switch ($entity) {
      case 'partner':
        break;

      case 'store':
        foreach (self::$images[$entity] as $k => $v) {
          $data[$v] = self::uploadImage($v);
        }
        break;

      case 'booking':
        $data['customers_id'] = !empty($_REQUEST['customer']) ? $_REQUEST['customer'] : \customer::$customer_id;
        self::createCustomer($id);
        break;

      case 'measurement':
        self::checkCredentials();
        $data['values'] = json_encode($_REQUEST['measurements']);
        break;

      case 'address':
        unset($data['op_stores_id'], $data['created_at'], $data['updated_at']);
        break;

      default:
        break;
    }

    db_insert(self::$schema[$entity]['table'], self::sanitizeEntries($data));
    $id = db_insert_id();

    switch ($entity) {
      case 'store':
        self::factoryDescriptions($id, $entity);
        break;

      case 'address':
        db_update('customers', [
          'customers_default_address_id' => 1,
          'customers_shipping_address_id' => 1,
        ], "customers_id = " . db_input($data['customers_id']));
        break;

    }

    if (self::checkDescription()) {
      self::createDescription($id, $entity);
    }

    self::sendNotification($id, $entity, 'create');

    return $id;

  }

  public static function createMultipleEntities($id, $entity) {
    $field = self::$schema[$entity]['multiple'];
    $loop = $_REQUEST[$field];
    foreach ($loop as $k => $v) {
      $_REQUEST[$field] = $v;
      $new_id = self::createEntity($id, $entity);
    }
    return $new_id;
  }

  public static function updateEntity($id, $entity) {

    self::checkIntegrity($id, $entity);

    if ($entity == 'order') {
        self::updateAccountingPeriod();
        return;
    }

    $data = self::setFields($entity);
    $data['updated_at'] = 'now()';

    if (!empty(self::$images[$entity])) {
      foreach (self::$images[$entity] as $k => $v) {
        $data[$v] = self::uploadImage($v);
        if (empty($data[$v])) {
          unset($data[$v]);
        } else {
          self::deleteImage($id, $entity, $v);
        }
      }
    }

    db_update(self::$schema[$entity]['table'], self::sanitizeEntries($data), 'id = ' . db_input($id));

    self::createStoreManager($id);

    if (self::checkDescription()) {
      self::updateDescription(key($_REQUEST['description']));
    }

    self::sendNotification($id, $entity, 'update');

  }

  public static function deleteEntity($id, $entity) {

    self::checkIntegrity($id, $entity);

    switch ($entity) {
        case 'partner':
            foreach (self::getPartnersStores($id) as $k => $v) {
                self::deleteEntity($k, 'store');
            }
            break;

        case 'store':
            foreach (self::getStoresContacts($id) as $k => $v) {
                self::deleteEntity($k, 'contact');
            }
            foreach (self::getStoresHours($id, false) as $k => $v) {
                self::deleteEntity($k, 'hour');
            }
            foreach (self::getStoresServices($id) as $k => $v) {
                self::deleteEntity($k, 'service');
            }
            foreach (self::getStoresCustomers($id) as $k => $v) {
                self::deleteEntity($k, 'customer');
            }
            break;

        case 'customer':
            db_update(self::$schema[$entity]['table'], [
              'ends_at' => 'now()',
              'deleted_at' => 'now()',
            ], 'id = ' . db_input($id));
            break;

        default:
            break;
    }

    db_update(self::$schema[$entity]['table'], [
      'deleted_at' => 'now()',
    ], 'id = ' . db_input($id));

    return;
  }

  public static function getStatus($id, $entity) {
    $sql = 'SELECT status FROM ' . self::$schema[$entity]['table'] . ' WHERE id = ' . db_input($id);
    return (bool) db_get_single_value($sql);
  }


  /********** PARTNERS **********/

  public static function getAllPartners($disabled = true) {
    $sql = 'SELECT * FROM op_partners WHERE deleted_at IS NULL' . ($disabled ? '' : ' AND status = 1');
    return db_get_assoc_key($sql);
  }

  private function getPartner($id) {
    $this->info = self::getPartnerInfo($id);
    $this->stores = self::getPartnersStores($id);
    $this->services = self::getPredefinedServices();
  }

  public static function getPartnerInfo($id) {
    $sql = 'SELECT * FROM op_partners WHERE id = ' . db_input($id);
    $res = db_get_single_row($sql);
    return $res;
  }


  /********** STORES **********/

  public static function getAllStores($sorted = false) {
    $stores = [];
    foreach (self::getAllPartners(false) as $k => $v) {
      $stores += self::getPartnersStores($k, true);
    }
    if ($sorted) {
      uasort($stores, function($a, $b) {
        return strcmp($a['name'], $b['name']);
      });
    }
    return $stores;
  }

  public static function getPartnersStores($id, $enabled = false, $simplified = false) {

    $sql = 'SELECT ps.*, c.countries_name
      FROM op_partners_stores ps
      LEFT JOIN ' . DB_CATALOG_DATABASE . '.countries c USING(countries_id)
      WHERE deleted_at IS NULL AND op_partners_id = ' . db_input($id) . ($enabled ? ' AND ps.status = 1' : '');

      $res = db_get_assoc_key($sql);

      if (!$simplified) {
        $commissions = self::getStoreCommissions($id);
        foreach ($res as $k => $v) {
          $res[$k]['services'] = self::getStoresServices($k);
          $res[$k]['contacts'] = self::getStoresContacts($k);
          $res[$k]['hours'] = self::getStoresHours($k);
          $res[$k]['description'] = self::getDescription($k, 'store');
          $res[$k]['bookings'] = self::getStoreBookings($k, null, 5);
          $res[$k]['customers'] = self::getStoresCustomers($k);
          $res[$k]['commissions'] = $commissions;
          $res[$k]['statistics'] = self::getStatistics($k, 'store');
          if ($manager = self::getStoreManager($k)) {
            $res[$k]['manager'] = $manager;
          }
        }
      }

    return $res;
  }

  public static function getStore($id) {
    self::checkIntegrity($id, 'store');
    $partnerId = self::tracePartner($id, 'store');
    $partner = new self($partnerId);
    return $partner->stores[$id];
  }


  /********** STORE MANAGER **********/

  private static function createStoreManager($id) {
    if (isset($_REQUEST['manager'])) {
      db_update('customers', ['op_stores_id' => 'null'], 'op_stores_id = "' . db_input($id) . '" AND customers_email_address != "' . db_input($_REQUEST['manager']) . '"');
      if (!empty($_REQUEST['manager'])) {
        db_update('customers', ['op_stores_id' => db_input($id)], 'customers_email_address = "' . db_input($_REQUEST['manager']) . '"');
      }
    }
  }

  private static function getStoreManager($id) {
    $sql = 'SELECT customers_id FROM customers WHERE op_stores_id = ' . db_input($id);
    if ($customersId = db_get_single_value($sql)) {
      $res = \customer::getCustomerInfoById($customersId);
      $res['customers_id'] = $customersId;
      return $res;
    }
    return null;
  }

  public static function setManagerSession() {
    $sql = 'SELECT op_stores_id FROM customers WHERE customers_id = "' . db_input(\customer::$customer_id) . '"';
    if ($OPStoreId = db_get_single_value($sql)) {
      $_SESSION[self::SESSION_STORE] = $OPStoreId;
    } else {
      unset($_SESSION[self::SESSION_STORE]);
    }
  }

  public static function buyAsCustomerSession($customerId, $toggle = true) {
    if ($toggle) {
      $_SESSION[self::SESSION_BUY_AS_CUSTOMER] = $customerId;
      $customer = \customer::getCustomerInfoById($customerId);
      $_SESSION['billto'] = $_SESSION['customer_default_address_id'] = $customer['customers_default_address_id'];
      $_SESSION['sendto'] = $_SESSION['customers_shipping_address_id'] = $customer['customers_shipping_address_id'];
    }
    else {
      unset($_SESSION[self::SESSION_BUY_AS_CUSTOMER]);
      $customer = \customer::getCustomerInfoById();
      $_SESSION['billto'] = $_SESSION['customer_default_address_id'] = $customer['customers_default_address_id'];
      $_SESSION['sendto'] = $_SESSION['customers_shipping_address_id'] = $customer['customers_shipping_address_id'];
    }
  }


  /********** COMMISSIONS **********/
  public static function getStoreCommissions($id) {
    $sql = 'SELECT commission_1, commission_2, commission_3, commission_4 FROM op_partners WHERE id = ' . db_input($id);
    return db_get_single_row($sql);
  }

  public static function getCommissionGroups() {
    $digest = ',';
    $groups = [];
    foreach (self::$commissionGroups as $k => $v) {
      $groups[$k] = rtrim(implode(',', $v), ',');
      $digest .= $groups[$k] . ',';
    }
    $digest = '\'' . str_replace(',', '\',\'', $digest) . '\'';
    $sql = 'SELECT GROUP_CONCAT(name) FROM product_types WHERE name NOT IN (' . $digest . ') AND name NOT LIKE "%ST%"';
    $groups[] = db_get_single_value($sql, 'catalog_link');
    foreach ($groups as $k => $v) {
      $groups[$k] = '&bull; ' . str_replace(['PRODUCT_TYPE_', ','], ['', ' &bull;&nbsp;'], $groups[$k]);
    }
    return $groups;
  }

  public static function getExcludedProductBrands() {
    $excludedProductBrands = [];
    $sql = 'SELECT cr2pb.products_brands_id, pdv.products_dictionaries_values_name
      FROM coupons_rule_to_products_brands cr2pb
      LEFT JOIN ' . DB_CATALOG_DATABASE . '.products_dictionaries_values pdv ON pdv.products_dictionaries_values_id = cr2pb.products_brands_id AND pdv.language_id = ' . get_current_language_id() . '
      WHERE
        cr2pb.rule_id = ' . OP_COUPON_RULE_ID;
      $excludedProductBrands = db_get_assoc($sql);
    return $excludedProductBrands;
  }

  public static function getCommissionGroupId($productType) {
      foreach (self::$commissionGroups as $groupId => $groupProductTypes) {
          if (in_array($productType, $groupProductTypes)) {
              return $groupId;
          }
      }

      return 4; // Default group for other product types
  }

  public static function calculateOrderCommission($orderId) {
      $order = new \order($orderId);
      // If orders is not fully paid OR Customer marked as reseller OR is test order. No commission for such orders / products.
      if ($order->getPaidDifference() < 0 || $order->customer['is_reseller'] || $order->info['test_order']) {
          return;
      }

      // Exclude store manager orders
      $storeManager = db_get_single_value('
        SELECT COUNT(op_stores_id) FROM customers WHERE op_stores_id IS NULL AND customers_id = '.db_input($order->customer['id'])
      );
      if ($storeManager != 0) {
          return;
      }

      // TODO '...ORDER BY created_at DESC' could be better
      $opticalOrder = db_get_single_row('
        SELECT * FROM '.db_input(self::$schema['order']['table']).' WHERE deleted_at IS NULL AND orders_id = '.db_input($order->id).' ORDER BY id DESC LIMIT 1'
      );
      if (!$opticalOrder) {
          return;
      }

      // Update or create new entry for new month
      $opticalOrder['order_total'] = \SwissVatRate::unVatAmount($order->totals['ot_total']['value'], $order->info['date_purchased']);
      $opticalOrder['commission_calc'] = $commissionCalc = 0;
      $opticalOrder['commission_diff'] = 0;
      if (date('m-Y', strtotime($opticalOrder['created_at'])) == date('m-Y')) {
          db_update(
            self::$schema['order']['table'],
            self::sanitizeEntries([
                'order_total' => $opticalOrder['order_total'],
                'commission_calc' => $opticalOrder['commission_calc'],
                'commission_diff' => $opticalOrder['commission_diff'],
                'updated_at' => 'now()'
            ]),
            'id = '.$opticalOrder['id']
          );
      } else {
          unset($opticalOrder['id']);
          $opticalOrder['status'] = self::ORDER_STATUS_OPEN;
          $opticalOrder['created_at'] =  $opticalOrder['updated_at'] = 'now()';
          $opticalOrder['issued_at'] = $opticalOrder['paid_at'] = $opticalOrder['deleted_at'] = null;
          db_insert(
            self::$schema['order']['table'],
            self::sanitizeEntries([
              'orders_id' => $opticalOrder['orders_id'],
              'customers_id' => $opticalOrder['customers_id'],
              'op_stores_id' => $opticalOrder['op_stores_id'],
              'on_behalf' => $opticalOrder['on_behalf'],
              'status' => $opticalOrder['status'],
              'order_total' => $opticalOrder['order_total'],
              'commission_calc' => $opticalOrder['commission_calc'],
              'commission_diff' => $opticalOrder['commission_diff'],
              'created_at' => 'now()',
              'updated_at' => 'now()'
            ])
          );
          $opticalOrder['id'] = db_insert_id();
      }

      // Remove old commission calculation
      db_delete(self::$schema['commission']['table'], 'op_stores_orders_id = '.db_input($opticalOrder['id']));

      $storeCommissionRates = self::getStoreCommissions($opticalOrder['op_stores_id']);
      $excludedProductBrands = array_keys(self::getExcludedProductBrands());
      $vatRate = \SwissVatRate::forDate($order->info['date_purchased']);
      if ($coupon = \Coupon::getCouponInOrder($order->id)) {
          $coupon = \Coupon::getCouponIdByCode($coupon);
          $coupon = \Coupon::getCoupon($coupon);

          // Coupon with fixed amount can't be applied per product, but per order
          if ($coupon['coupon_type'] == 'F') {
              $commission['op_stores_orders_id'] = $opticalOrder['id'];
              $commission['amount'] = (-1) * $coupon['coupon_amount'] / (100 + $vatRate) * 100 / 2;
              $commission['created_at'] = $commission['updated_at'] = 'now()';  // TODO
              db_insert(self::$schema['commission']['table'], $commission);
              $commissionCalc += $commission['amount'];
          }
      }

      foreach($order->products as $product) {

          if ($coupon['coupon_type'] == 'P' && $product['variant_special_price'] != 1) {
              $product['price'] = $product['price'] - ($product['price'] / 100 * $coupon['coupon_amount']);
          }

          // Netto prices - Commission is calculated from netto price (without VAT).
          $nettoPrice = $product['price'] / (100 + $vatRate) * 100 * $product['qty'];
          $commissionGroupId = self::getCommissionGroupId($product['type_name']);

          // Skip forbidden product brands
          $productBrandId = \Dictionary::getProductDictionaryValues($product['products_id'], 'DICTIONARY_PRODUCT_BRAND')['dictionaries_values_id'];
          if (in_array($productBrandId, $excludedProductBrands)) {
              $commissionRate = 0;
              $commissionAmount = 0;
          } else {
              $commissionRate = $storeCommissionRates['commission_'.$commissionGroupId]; // TODO: ugly
              $commissionAmount = $nettoPrice / 100 * $commissionRate;
          }

          // Save calculated data
          $data = self::setFields('commission');
          $data['op_stores_orders_id'] = $opticalOrder['id'];
          $data['orders_products_id'] = $product['orders_products_id'];
          $data['group'] = $commissionGroupId;
          $data['rate'] = $commissionRate;
          // Products with special price - 50% of regular commission rate.
          $data['amount'] = ($product['variant_special_price']) ? ($commissionAmount/2) : $commissionAmount;
          $data['product_type_id'] = $product['types_id'];
          $data['created_at'] = $data['updated_at'] = 'now()';
          db_insert(self::$schema['commission']['table'], self::sanitizeEntries($data));
          $commissionCalc += $data['amount'];
      }

      // Update store order totals
      $commissionDiff = db_get_single_value('
        SELECT '.$commissionCalc.' - SUM(commission_diff) 
        FROM '.self::$schema['order']['table'].' 
        WHERE orders_id = '.$order->id
      );
      db_update(self::$schema['order']['table'], [
        'commission_calc' => $commissionCalc,
        'commission_diff' => $commissionDiff,
      ], 'id = '.db_input($opticalOrder['id']));
  }


  /********** SERVICES **********/

  public static function getStoresServices($id) {
    $sql = '
      SELECT id, duration, price
      FROM '.self::$schema['service']['table'].'
      WHERE deleted_at IS NULL AND op_stores_id = ' . db_input($id);
    foreach ($res = db_get_assoc_key($sql) as $k => $v) {
      $res[$k]['description'] = self::getDescription($k, 'service');
    }
    return $res;
  }

  public static function getPredefinedServices() {
    $data = [];
    $languages = self::getLanguages();
    for ($i = 1; $i < 7; $i++) {
      foreach ($languages as $k => $v) {
        $data['OP_SERVICE_' . $i][$k] = t('OP_SERVICE_' . $i, $k);
      }
    }
    return $data;
  }


  /********** CONTACTS **********/

  public static function getStoresContacts($id) {
    $sql = 'SELECT * FROM '.self::$schema['contact']['table'].' WHERE deleted_at IS NULL AND op_stores_id = ' . db_input($id);
    return db_get_assoc_key($sql);
  }

  public static function getStoreDefaultContact($id) {
    $sql = 'SELECT * FROM op_stores_contacts WHERE deleted_at IS NULL AND private = 0 AND op_stores_id = ' . db_input($id) . ' LIMIT 1';
    return db_get_single_row($sql);
  }

  public static function resetContact($id) {
    db_update('op_partners_stores', ['op_stores_contacts_id' => 'null'], 'op_stores_contacts_id = ' . db_input($id));
  }


  /********** HOURS **********/

  public static function getStoresHours($id, $organized = true) {
    $hours = [
      'regular' => [],
      'special' => [],
    ];
    $sql = 'SELECT * FROM '.self::$schema['hour']['table'].' WHERE deleted_at IS NULL AND op_stores_id = ' . db_input($id) . ' ORDER BY weekday, starts_at';
    $res = db_get_arrays($sql);
    if ($organized) {
      foreach ($res as $k => $v) {
        if ($res[$k]['weekday'] > 0 && $res[$k]['weekday'] < 8) {
          $hours['regular'][$res[$k]['weekday']][$res[$k]['id']] = [
            'starts_at' => $res[$k]['starts_at'],
            'ends_at' => $res[$k]['ends_at'],
          ];
        } else {
          if (!empty($res[$k]['date_from'])) {
            if (!empty($res[$k]['date_to'])) {
              $period = new \DatePeriod(new \DateTime($res[$k]['date_from']), new \DateInterval('P1D'), new \DateTime($res[$k]['date_to'] . '+1 day'));
              foreach ($period as $date) {
                $hours['special'][$date->format('Y-m-d')][$res[$k]['id']] = [
                  'starts_at' => $res[$k]['starts_at'],
                  'ends_at' => $res[$k]['ends_at'],
                  'description' => self::getDescription($res[$k]['id'], 'hour'),
                ];
              }
            } else {
              $hours['special'][$res[$k]['date_from']][$res[$k]['id']] = [
                'starts_at' => $res[$k]['starts_at'],
                'ends_at' => $res[$k]['ends_at'],
                'description' => self::getDescription($res[$k]['id'], 'hour'),
              ];
            }
          }
        }
      }
      ksort($hours['special']);
    } else {
      $hours = db_get_assoc_key($sql);
    }
    return $hours;
  }

  public static function createHours($id) {
    if (is_array($_REQUEST['weekday'])) {
      $days = $_REQUEST['weekday'];
      foreach ($days as $k => $v) {
        $_REQUEST['weekday'] = $v;
        $res = self::createEntity($id, 'hour');
      }
      return $res;
    } else {
      return self::createEntity($id, 'hour');
    }
  }


  /********** BOOKINGS **********/

  public static function getStoreBookings($id, $startsAt = null, $days = null, $organized = true, $past = false, $cancelled = false) {
    $startsAt = $date = (!$startsAt) ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($startsAt));
    $days = (is_numeric($days)) ? $days : 7;
    $endsAt = date('Y-m-d H:i:s', strtotime($startsAt . " +$days day"));
    if ($past) {
      $condition = 'AND (sb.starts_at <= "' . db_input($startsAt) . '")';
      $sort = ' ORDER BY sb.starts_at DESC';
    } else {
      $condition = 'AND (sb.starts_at BETWEEN "' . db_input($startsAt) . '" AND "' . db_input($endsAt) . '")';
      $sort = ' ORDER BY sb.starts_at ASC';
    }

    if (!$cancelled) {
        $condition .= ' AND sb.cancelled_at IS NULL ';
    }

    $sql = 'SELECT sb.*, DATE(sb.starts_at) AS starts_date, ss.duration
      FROM '.self::$schema['booking']['table'].' sb
      LEFT JOIN '.self::$schema['service']['table'].' ss
        ON ss.id = sb.op_services_id
      WHERE sb.deleted_at IS NULL 
        AND ss.deleted_at IS NULL
        AND sb.op_stores_id = ' . db_input($id) . ' 
        ' . $condition . $sort;
    $bookings = db_get_assoc_key($sql);

    foreach ($bookings as $k => $v) {
      $bookings[$k]['name'] = self::getDescription($bookings[$k]['op_services_id'], 'service')['name'][get_current_language_id()]['content'];
    }

    if ($organized) {
      $res = [];
      $period = new \DatePeriod(new \DateTime($startsAt), new \DateInterval('P1D'), new \DateTime($endsAt));
      foreach ($period as $date) {
        $date = $date->format('Y-m-d');
        if (!isset($res[$date])) {
          $res[$date] = [];
        }
        $search = array_combine(array_keys($bookings), array_column($bookings, 'starts_date'));
        $search = array_keys($search, $date);
        foreach ($search as $k) {
          $res[$date][$k] = $bookings[$k];
        }
      }
    } else {
      $res = $bookings;
    }
    return $res;
  }

  public static function getCustomerBookings($id = null, $cancelled = false) {
    $sql = '
      SELECT
        sb.*,
        d.content AS name,
        IF(sb.starts_at >= NOW() - INTERVAL ' . OP_BOOKING_PAST_PERIOD . ' DAY, 1, 0) AS editable,
        IF(sb.starts_at >= NOW(), 1, 0) AS cancellable
      FROM '.self::$schema['booking']['table'].' sb
      LEFT JOIN '.self::$schema['service']['table'].' ss ON ss.id = sb.op_services_id
      LEFT JOIN op_descriptions d ON d.entity_id = sb.op_services_id AND d.language_id = ' . get_current_language_id() . ' AND d.entity_type = "service"
      WHERE
        sb.deleted_at IS NULL
        AND ss.deleted_at IS NULL
        AND sb.customers_id = ' . db_input($id ? $id : \customer::$customer_id) . ' 
          ' . (($cancelled) ? "" : "AND sb.cancelled_at IS NULL") . '
      ORDER BY sb.starts_at';
    $res = db_get_assoc_key($sql);
    return $res;
  }

  public static function getBooking($id, $cancelled = false) {
    $sql = 'SELECT sb.*, ss.duration 
      FROM '.self::$schema['booking']['table'].' sb 
      LEFT JOIN '.self::$schema['service']['table'].' ss
        ON ss.id = sb.op_services_id 
      WHERE sb.deleted_at IS NULL 
        AND ss.deleted_at IS NULL 
        ' . (($cancelled) ? "" : "AND sb.cancelled_at IS NULL") . '
        AND sb.id = ' . db_input($id);
    $res = db_get_single_row($sql);
    $res['name'] = self::getDescription($res['op_services_id'], 'service')['name'][get_current_language_id()]['content'];
    return $res;
  }

  public static function cancelBooking($id) {
    self::checkIntegrity($id, 'booking');
    db_update(self::$schema['booking']['table'], [
      'cancelled_at' => 'now()',
      'updated_at' => 'now()',
    ], 'id = ' . db_input($id));
    self::sendNotification($id, 'booking', 'cancel');
  }

  public static function rescheduleBooking($id) {
    self::checkIntegrity($id, 'booking');
    db_update(self::$schema['booking']['table'], [
      '@starts_at' => '"' . $_REQUEST['starts_at'] . '"',
      'updated_at' => 'now()',
    ], 'id = ' . db_input($id));
    self::sendNotification($id, 'booking', 'reschedule');
  }


  /********** CUSTOMERS **********/

  public static function getStoresCustomers($id, $active = true) {
    self::checkIntegrity($id, 'store');
    $sql = 'SELECT sc.*, ab.*, c.*, CONCAT(c.customers_firstname, " ", c.customers_lastname) AS name
      FROM ' . self::$schema['customer']['table'] . ' sc
      JOIN customers c
        USING (customers_id)
      LEFT JOIN address_book ab 
        ON ab.customers_id = c.customers_id 
        AND ab.address_book_id = c.customers_default_address_id
      WHERE sc.deleted_at IS NULL 
        AND sc.op_stores_id = ' . db_input($id);
    $sql .= ($active) ? " AND sc.ends_at IS NULL " : "";

    if (isset($_REQUEST['search'])) {
      $sql .= ' AND c.customers_firstname LIKE "%' . db_input($_REQUEST['search']['firstname']) . '%" ';
      $sql .= ' AND c.customers_lastname LIKE "%' . db_input($_REQUEST['search']['lastname']) . '%" ';
    }

    return db_get_assoc_key($sql . ' GROUP BY sc.customers_id');
  }

  public static function getCustomer($id) {
    $sql = 'SELECT sc.*, CONCAT(c.customers_firstname, " ", c.customers_lastname) AS name 
      FROM ' . self::$schema['customer']['table'] . ' sc
      LEFT JOIN customers c
        USING (customers_id)
      WHERE sc.deleted_at IS NULL 
        AND sc.customers_id = ' . db_input($id);
    return db_get_single_row($sql);
  }

  public static function getCustomerActiveAssignment($id) {
    $sql = 'SELECT op_stores_id FROM ' . self::$schema['customer']['table'] . ' WHERE customers_id = ' . db_input($id) . ' AND ends_at IS NULL AND deleted_at IS NULL ORDER BY starts_at ASC';
    return db_get_single_values_array($sql);
  }

  public static function createCustomer($id, $customerId = null) {
    self::checkIntegrity($id, 'store');
    $customerId = ($customerId) ? $customerId : \customer::$customer_id;
    if (!in_array($id, self::getCustomerActiveAssignment($customerId))) {
      $data = self::setFields('customer');
      $data['customers_id'] = $customerId;
      $data['starts_at'] = 'now()';
      $data['created_at'] = 'now()';
      $data['op_stores_id'] = $id;
      db_insert(self::$schema['customer']['table'], self::sanitizeEntries($data));
      return db_insert_id();
    }
  }

  public static function takeOverCustomer($id) {
      $data = self::setFields('customer');
      $data['op_stores_id'] = $_SESSION[self::SESSION_STORE];
      $data['customers_id'] = $id;
      $data['created_at'] = 'now()';
      $data['starts_at'] = 'now()';
      db_insert(self::$schema['customer']['table'], self::sanitizeEntries($data));
      return db_insert_id();
  }

  public static function checkBuyAsCustomer() {
    return (!empty($_SESSION[self::SESSION_STORE]) && !empty($_SESSION[self::SESSION_BUY_AS_CUSTOMER])) ? true : false;
  }

  public static function onBehalfOfCustomerId() {
      if (self::checkBuyAsCustomer() && self::$onBehalfOfCustomerId == null) {
          self::$onBehalfOfCustomerId = \customer::$customer_id;
          \customer::$customer_id = $_SESSION[self::SESSION_BUY_AS_CUSTOMER];
      }
  }


  /********** MEASUREMENTS **********/

  public static function getCustomerMeasurements($id) {
    $sql = 'SELECT id FROM '.self::$schema['measurement']['table'].' WHERE customers_id = '.db_input($id).' AND deleted_at IS NULL';
    $measurements = db_get_single_values_array($sql);
    $res = [];
    foreach ($measurements as $k) {
      $res[$k] = self::getMeasurement($k);
    }

    return $res;
  }

  public static function getMeasurement($id) {
    $sql = 'SELECT * FROM ' . self::$schema['measurement']['table'] . ' WHERE id = ' . db_input($id);
    $res = db_get_single_row($sql);
    $res['data'] = json_decode(stripslashes($res['values']));
    $res['service'] = self::getDescription($res['op_services_id'], 'service')['name'][get_current_language_id()];
    return $res;
  }


  /********** ORDERS **********/

  public static function getOrders($storeId, $customerId = null) {
      $conditions = '';
      // Get only orders in period "05/2018"
      if (!empty($_REQUEST['period'])) {
          $conditions .= self::getPeriodCondition($_REQUEST['period']);
      }
      if ($customerId) {
          $conditions .= ' AND o.customers_id = '.db_input($customerId);
      }
      if (!empty($_REQUEST['orders_id'])) {
          $conditions .= ' AND o.orders_id = '.db_input($_REQUEST['orders_id']);
      }

      $sql = '
          SELECT
            o.orders_id,
            so.id AS stores_orders_id,
            o.date_purchased,
            o.shipping_id,
            so.status,
            so.order_total AS total_value,
            c.customers_id,
            CONCAT(c.customers_firstname, " ", c.customers_lastname) AS customer,
            so.commission_diff AS commission,
            IF(YEAR(so.created_at) = YEAR(o.date_purchased) && MONTH(so.created_at) = MONTH(o.date_purchased), 0, 1) AS clearance
          FROM orders o
          LEFT JOIN '.self::$schema['customer']['table'].' sc
            USING(customers_id)
          JOIN customers c
            USING(customers_id)
          JOIN '.self::$schema['order']['table'].' so
            ON so.orders_id = o.orders_id
            AND so.op_stores_id = '.db_input($storeId).'
          WHERE sc.deleted_at IS NULL
            AND so.deleted_at IS NULL
            '.$conditions.' 
          GROUP BY o.orders_id
          ORDER BY o.orders_id DESC';

      return $sql;
  }

  public static function getOrderPackageInfo($orderId) {
      $packages = db_get_assoc_key(
        '
              SELECT p.*, sp.*, sp.id AS id, h.created_at AS delivered_at 
              FROM package p
              LEFT JOIN '.self::$schema['package']['table'].' sp
                USING(orders_id, package_id)
              LEFT JOIN op_history h
                ON h.entity_id = sp.id
                AND h.entity_type = "package"
                AND h.field = "status"
                AND h.value IN ("'.self::PACKAGE_STATUS_PICKED_UP.'", "'.self::PACKAGE_STATUS_DELIVERED.'")
                AND h.created_at IS NOT NULL
              WHERE sp.deleted_at IS NULL 
                AND p.orders_id = '.db_input($orderId).'
          '
      );

      foreach ($packages as $packageId => &$package) {
          $package['content'] = db_get_assoc_key(
            '
                  SELECT pc.*, op.products_name 
                  FROM package_content pc
                  LEFT JOIN orders_products op
                    USING(orders_products_id)
                  WHERE pc.orders_id = '.db_input($package['orders_id']).' 
                    AND pc.package_id = '.db_input($packageId).'
              '
          );
      }

      return $packages;
  }

  public static function getStorePackage($opStoresPackagesId) {
      $sql = '
        SELECT sp.*, so.orders_id, so.op_stores_id, so.status
        FROM ' . self::$schema['package']['table'] . ' sp
        JOIN ' . self::$schema['order']['table'] . ' so ON so.id = sp.op_stores_orders_id
        WHERE
          sp.deleted_at IS NULL
          AND so.deleted_at IS NULL
          AND sp.id = ' . db_input($opStoresPackagesId);

      return db_get_single_row($sql);
  }

  public static function getAccountingPeriods($storeId) {
      $sql = '
        SELECT
          DATE_FORMAT(so.created_at, "%m/%Y") AS date,
          COUNT(o.orders_id) AS orders_count,
          so.invoice_number,
          so.issued_at,
          so.paid_at,
          so.id,
          SUM(so.order_total) AS total,
          SUM(so.commission_diff) AS commission
        FROM '.self::$schema['order']['table'].' so
        JOIN orders o
          USING(orders_id)
        JOIN customers c
          ON c.customers_id = o.customers_id
          AND c.is_reseller = 0
        JOIN orders_total ot
          ON ot.orders_id = so.orders_id
          AND ot.class = "ot_total"
        WHERE so.op_stores_id = '.db_input($storeId).'
          AND so.deleted_at IS NULL
        GROUP BY YEAR(so.created_at), MONTH(so.created_at)
        ORDER BY so.created_at DESC
    ';

    return db_get_assoc_arrays($sql);
  }

  private static function updateAccountingPeriod() {
      if (empty($_REQUEST['invoice_number']) || empty($_REQUEST['issued_at']) || empty($_REQUEST['paid_at'])) {
          return false;
      }

      $period = db_get_single_row('
        SELECT 
          YEAR(created_at) AS periodYear, 
          MONTH(created_at) AS periodMonth 
        FROM '.self::$schema['order']['table'].' 
        WHERE id = '.db_input($_REQUEST['id']));

      db_update(
        self::$schema['order']['table'],
        [
          'invoice_number' => $_REQUEST['invoice_number'],
          'issued_at' => $_REQUEST['issued_at'],
          'paid_at' => $_REQUEST['paid_at'],
          'updated_at' => 'now()',
        ],
        'YEAR(created_at) = '.db_input($period['periodYear']).' AND MONTH(created_at) = '.db_input($period['periodMonth'])
      );
  }

  public static function getAccountingOrders($storeId) {
    global $smarty;
    $sql = self::getOrders($storeId);
    $pagination = Pagination::fromQuery($sql)
      ->perPage(OP_RECORDS_PER_PAGE)
      ->get('db_get_assoc_key');

    foreach ($pagination->data as $orderId => &$order) {
        $data = self::getAccountingOrder($order['stores_orders_id']);
        $order['items'] = $data['items'];
        $order['previous_commissions'] = $data['previous_commissions'];
    }

    $result['summary'] = [
      'total_value' => array_sum(array_column($pagination->data, 'total_value')),
      'commission' => array_sum(array_column($pagination->data, 'commission')),
    ];

    $result['current'] = array_filter($pagination->data, function($order) {
       return (!$order['clearance']);
    });
    $result['previous'] = array_filter($pagination->data, function($order) {
        return ($order['clearance']);
    });
    $result['paginationLinks'] = $pagination->links($smarty);

    return $result;
  }

  public static function getAccountingOrder($opStoresOrdersId) {
      $order = db_get_single_row('
        SELECT o.orders_id, o.date_purchased 
        FROM '.self::$schema['order']['table'].' so
        JOIN orders o
            USING(orders_id)
        WHERE id = '.db_input($opStoresOrdersId)
      );

      $vatRate = \SwissVatRate::forDate($order['date_purchased']);
      $result['items'] = db_get_assoc_key('
            SELECT *, (op.products_price / (100 + '.$vatRate.') * 100) AS products_price
            FROM '.self::$schema['commission']['table'].' sc
            LEFT JOIN orders_products op
              USING(orders_products_id)
            WHERE sc.deleted_at IS NULL 
              AND sc.op_stores_orders_id = '.db_input($opStoresOrdersId)
      );
      $result['previous_commissions'] = db_get_arrays('
          SELECT 
            DATE_FORMAT(created_at, "%m/%Y") AS period,
            commission_diff AS commission
          FROM '.self::$schema['order']['table'].' 
          WHERE orders_id = '.db_input($order['orders_id']).'
          ORDER BY created_at ASC'
      );

      return $result;
  }

  public static function assignOrder(\order $order) {
      $storesId = self::getCustomerActiveAssignment(\customer::$customer_id);
      if (count($storesId)) {
          $storesId = reset($storesId); // Returns first assignment "... ORDER BY starts_at ASC"
          self::checkIntegrity($storesId, 'store');
          $data = self::setFields('order');
          $data['orders_id'] = $order->id;
          $data['customers_id'] = \customer::$customer_id;
          $data['op_stores_id'] = $storesId;
          $data['on_behalf'] = self::checkBuyAsCustomer();
          $data['status'] = self::ORDER_STATUS_OPEN;
          $data['order_total'] = \SwissVatRate::unVatAmount($order->info['total']);
          $data['created_at'] = $data['updated_at'] = 'now()';
          db_insert(self::$schema['order']['table'], self::sanitizeEntries($data));
          $result = db_insert_id();
          self::createHistory([
            'entity_id' => db_input($order->id),
            'entity_type' => 'order',
            'field' => 'status',
            'value' => self::ORDER_STATUS_OPEN,
          ]);

          return $result;
      }
  }

  public static function searchOrderById($ordersId) {
    $sql = '
      SELECT 
        o.orders_id,
        so.id AS stores_orders_id, 
        o.date_purchased,
        o.shipping_id,
        so.status,
        so.order_total AS total_value,
        c.customers_id,
        CONCAT(c.customers_firstname, " ", c.customers_lastname) AS customer,
        so.commission_diff AS commission
      FROM '.self::$schema['order']['table'].' so
      JOIN orders o
        USING(orders_id)
      JOIN customers c
        ON o.customers_id = c.customers_id
      WHERE so.op_stores_id = '.db_input($_SESSION[self::SESSION_STORE]).'
        AND so.orders_id = '.db_input($ordersId);

    return $sql;
  }


  /********** ADDRESSES **********/

  public static function fillPickUpAddress($shipping_address) {
    if (isset($_SESSION[self::SESSION_STORE])) {
      $storeId = $_SESSION[self::SESSION_STORE];
    } else if (count(self::getCustomerActiveAssignment(\customer::$customer_id))) {
      $storeId = reset(self::getCustomerActiveAssignment(\customer::$customer_id));
    } else {
        return $shipping_address;
    }
    $store = self::getStore($storeId);
    $country = \Countries::getCountryInfoByName($store['countries_id']);

    return [
      'firstname' => $shipping_address['entry_firstname'],
      'lastname' => $shipping_address['entry_lastname'],
      'company' => $store['name'],
      'street_address' => $store['street'],
      'city' => $store['city'],
      'postcode' => $store['zip'],
      'country' => array(
        'id' => $country['countries_id'],
        'title' => $country['countries_name'],
        'iso_code_2' => $country['countries_iso_code_2'],
        'iso_code_3' => $country['countries_iso_code_3'],
        'region_name' => $country['region_name'],
      ),
      'country_id' => $country['countries_id'],
      'delivery_country_id' => $country['countries_id'],
    ];
  }

  public static function getAddressLabel() {
      if (isset($_SESSION[self::SESSION_STORE])) {
        $storeId = $_SESSION[self::SESSION_STORE];
        $customerId = $_SESSION[self::SESSION_BUY_AS_CUSTOMER];
      } else if (count(self::getCustomerActiveAssignment(\customer::$customer_id))) {
        $customerId = \customer::$customer_id;
        $storeId = reset(self::getCustomerActiveAssignment($customerId));
      } else {
          return '';
      }
      $store = self::getStore($storeId);

      $result = \customer::get_customers_name($customerId) . "<br/>";
      $result .= $store['name'] . "<br/>";
      $result .= $store['street'] . "<br/>";
      $result .= $store['zip'] . " ";
      $result .= $store['city'] . "<br/>";
      $result .= \Countries::getCountryInfoByName($store['countries_id'])['countries_name'];

      return $result;
  }


  /********** HELPERS **********/

  public static function checkMultipleCreation($entity) {
    $field = self::$schema[$entity]['multiple'];
    return !empty($field) && !empty($_REQUEST[$field]) && is_array($_REQUEST[$field]) ? true : false;
  }

  public static function checkExistence($id, $entity) {
    $sql = 'SELECT id FROM ' . self::$schema[$entity]['table'] . ' WHERE deleted_at IS NULL AND id = ' . $id;
    $res = db_get_single_value($sql);
    return !empty($res) ? true : false;
  }

  public static function checkIntegrity($id, $entity) {
    if (!array_key_exists($entity, self::$schema) || !self::checkExistence($id, $entity)) {
      $lang = self::getLanguages()[get_current_language_id()]['code'];
      if ($_SESSION[self::SESSION_STORE]) {
        $redirect = '/' . $lang . '/op_admin_details.php';
      } elseif ($_SESSION['loggedin_as_admin'] && BRAND_SECTION == 'admin') {
        $redirect = '/admin/optical_partners.php';
      } else {
        $redirect = '/' . $lang . '/optical_partners_overview.php';
      }
      \messageStack::addSession(t('OP_MSG_INTEGRITY_ERROR'), \messageStack::TYPE_ERROR);
      tep_redirect($redirect);
    }
    return true;
  }

  public static function checkCredentials() {
    $message = 'ACCESS_DENIED';
    \Security::CheckCustomerLoggedIn();
    if (isset($_SESSION[self::SESSION_STORE])) {
      $storeId = $_SESSION[self::SESSION_STORE];
      if (self::checkIntegrity($storeId, 'store')) {
        $partnerId = self::tracePartner($storeId, 'store');
        if (self::getStatus($storeId, 'store')) {
          $partnerInfo = self::getPartnerInfo($partnerId);
          if ($partnerInfo['status']) {
            return true;
          }
        }
        $message = 'OP_FE_ADMIN_ACCOUNT_DISABLED';
      }
    }

    \messageStack::addSession(t($message), \messageStack::TYPE_ERROR);
    return tep_redirect(tep_href_link('home.php', '', 'SSL'));
  }

  public static function getEntity() {
    return isset($_REQUEST['entity']) && !empty($_REQUEST['entity']) && array_key_exists($_REQUEST['entity'], self::$schema) ? $_REQUEST['entity'] : 'partner';
  }

  public static function getAction() {
    return isset($_REQUEST['action']) && !empty($_REQUEST['action']) && in_array($_REQUEST['action'], self::$actions) ? $_REQUEST['action'] : 'list';
  }

  public static function getId($entity) {
    if (isset($_REQUEST[$entity]) && !empty($_REQUEST[$entity]) && is_numeric((int) $_REQUEST[$entity]) && (int) $_REQUEST[$entity] > 0) {
      return $_REQUEST[$entity];
    }
    return 0;
  }

  public static function getFirstId($entity) {
    if (array_key_exists($entity, self::$schema)) {
      $sql = 'SELECT id FROM ' . self::$schema[$entity]['table'] . ' WHERE deleted_at IS NULL';
      $res = db_get_single_value($sql);
    }
    return !empty($res) ? $res : 0;
  }

  public static function getPath() {
    return DIR_FS_DOCUMENT_ROOT . 'images/' . SITE_ID . '/optical_partners/';
  }

  public static function getLanguages() {
    $languages = \MultiLang::get_languages();
    asort($languages);
    return $languages;
  }

  public static function setFields($entity) {

    $data = $_REQUEST;

    if ($entity === 'booking' && !empty($_REQUEST['attended_at'])) {
      $data['attended_at'] = 'now()';
    }

    foreach (self::$toggles as $k => $v) {
      if (!isset($data[$v])) {
        $data[$v] = '';
      }
    }

    if (in_array($_REQUEST['action'], ['create', 'assign']) && $entity !== 'partner') {
      $data['op_' . self::$schema[$entity]['parent'] . 's_id'] = $data['id'];
    }

    foreach ($data as $k => $v) {
      if (!in_array($k, self::$schema[$entity]['fields'])) {
        unset($data[$k]);
      }
    }

    unset($data['id']);

    return $data;

  }

  public static function sanitizeEntries($data) {
    foreach ($data as $k => $v) {
      $data[$k] = db_input(trim($v));
      if (in_array($k, self::$spaceless)) {
        $data[$k] = str_replace(' ', '', $v);
      }
      if (in_array($k, self::$toggles) && empty($v)) {
        $data[$k] = 0;
      }
    }
    return $data;
  }

  public static function FWD($id, $entity, $action) {

    $fwd['partner'] = ($entity != 'partner' ? self::tracePartner($id, $entity) : $id);
    $fwd['action'] = 'edit';
    switch ($entity) {
      case 'partner':
        if ($action == 'delete') {
          $fwd['partner'] = self::getFirstId('partner');
          $fwd['action'] = 'list';
        }
        break;
      case 'store':
        if ($action != 'delete') {
          $fwd['store'] = $id;
        }
        break;
      default:
        $fwd['store'] = self::traceStore($id, $entity);
        break;
    }
    if (isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])) {
      $fwd['tab'] = $_REQUEST['tab'];
    }
    return $fwd;

  }

  public static function MSG($entity, $action) {
    return ucfirst(sprintf(t('OP_MSG_UNIVERSAL'), $entity, $action . 'd'));
  }

  public static function redirect($a = []) {
    tep_redirect($_SERVER['SCRIPT_NAME'] . (!empty($a) ? '?' . http_build_query($a, '', '&') : ''));
  }

  public static function getPeriodCondition($period) {
    $tmp = explode('/', $period);
    $res = ' AND MONTH(so.created_at) = "' . db_input($tmp[0]) . '" AND YEAR(so.created_at) = "' . db_input($tmp[1]) . '"';
    return $res;
  }

  /********** IMAGES **********/

  public static function uploadImage($img) {
    if (isset($_FILES[$img]) && !empty($_FILES[$img]) && $_FILES[$img]['error'] === 0) {
      $file = uniqid() . '.' . pathinfo($_FILES[$img]['name'], PATHINFO_EXTENSION);
      if (!file_exists(self::getPath())) {
        mkdir(self::getPath(), 0755, true);
      }
      move_uploaded_file($_FILES[$img]['tmp_name'], self::getPath() . $file);
    }
    return empty($file) ? '' : $file;
  }

  public static function deleteImage($id, $entity, $img) {
    $sql = 'SELECT ' . $img . ' FROM ' . self::$schema[$entity]['table'] . ' WHERE id = ' . db_input($id);
    $res = db_get_single_value($sql);
    if (!empty($res)) {
      unlink(self::getPath() . $res);
    }
  }


  /********** DESCRIPTIONS **********/

  public static function getDescription($id, $entity, $organized = true) {
    $contents = [];
    $sql = 'SELECT * FROM op_descriptions WHERE entity_id = ' . db_input($id) . ' AND entity_type = "' . db_input($entity) . '" AND deleted_at IS NULL';
    if ($organized) {
      foreach ($res = db_get_arrays($sql) as $k => $v) {
        if (!empty($res[$k]['section']) && in_array($res[$k]['section'], self::$sections[$entity])) {
          $contents[$res[$k]['section']][$res[$k]['language_id']] = $res[$k];
          unset($contents[$res[$k]['section']][$res[$k]['language_id']]['section']);
          unset($contents[$res[$k]['section']][$res[$k]['language_id']]['language_id']);
        }
      }
      return $contents;
    } else {
      $sql .= ' AND language_id = ' . get_current_language_id();
      $res = db_get_single_value(str_replace('*', 'content', $sql));
      return $res;
    }
  }

  public static function createDescription($id, $entity) {
    $description = $_REQUEST['description'];
    foreach ($description as $section => $v) {
      foreach ($description[$section] as $language => $content) {
        db_insert('op_descriptions', [
          'entity_id' => $id,
          'entity_type' => $entity,
          'language_id' => $language,
          'section' => $section,
          'content' => $content,
          'created_at' => 'now()',
          'updated_at' => 'now()',
        ]);
      }
    }
  }

  public static function updateDescription() {
    foreach ($_REQUEST['description'] as $k => $v) {
      db_update('op_descriptions', [
        'content' => db_input($v),
        'updated_at' => 'now()',
      ], 'id = ' . db_input($k));
    }
  }

  public static function factoryDescription($id, $entity, $section = null) {
    $data = [];
    foreach (self::getLanguages() as $k => $v) {
      $data = [
        'entity_id' => $id,
        'entity_type' => $entity,
        'language_id' => $k,
        'section' => empty($section) ? 'null' : $section,
        'created_at' => 'now()',
      ];
      db_insert('op_descriptions', $data);
    }
  }

  public static function factoryDescriptions($id, $entity) {
    switch ($entity) {
      case 'store':
        foreach (self::$sections[$entity] as $k => $v) {
          self::factoryDescription($id, $entity, $v);
        }
      break;
    }
    return;
  }

  public static function deleteDescriptions($id, $entity) {
    db_update('op_descriptions', [
      'deleted_at' => 'now()',
    ], 'entity_id = ' . db_input($id) . ' AND entity_type = "' . db_input($entity) . '"');
  }

  public static function checkDescription() {
    return isset($_REQUEST['description']) && !empty($_REQUEST['description'] && is_array($_REQUEST['description'])) ? true : false;
  }


  /********** HISTORY **********/

  public static function createHistory($data) {
    $data['created_at'] = 'now()';
    db_insert(
      self::$schema['history']['table'],
      self::sanitizeEntries($data)
    );
    return db_insert_id();
  }


  /********** NOTIFICATIONS **********/

  public static function sendNotification($id, $entity, $action) {

    switch ($entity) {

      case 'booking':

        if (in_array($action, ['create', 'cancel', 'reschedule', 'remind']) && !empty($data = self::getBooking($id, true))) {

          $data = self::getCommonNotificationData($data);

          if (CustomerEmail::checkExistsTemplate($tpl = 'OP_BOOKING_' . strtoupper($action))) {
            CustomerEmail::fromTemplate($tpl, $data['customer']['languages_id'])
            ->withSender(OP_NOTIFICATIONS_NAME_FROM, OP_NOTIFICATIONS_BOOKING_EMAIL_FROM)
            ->withRecipient('', $data['customer']['customers_email_address'])
            ->withExtraRecipients(['CC' => [$data['contact']['email']]])
            ->replacePlaceholders(['booking' => $data])
            ->send();
            return true;
          }

        }

      case 'service':

        if ($action == 'remind' && !empty($data = self::getMeasurement($id)) && CustomerEmail::checkExistsTemplate('OP_SERVICE_REMIND')) {

          $data = self::getCommonNotificationData($data);

          CustomerEmail::fromTemplate('OP_SERVICE_REMIND', $data['customer']['languages_id'])
            ->withSender(OP_NOTIFICATIONS_NAME_FROM, OP_NOTIFICATIONS_BOOKING_EMAIL_FROM)
            ->withRecipient('', $data['customer']['customers_email_address'])
            ->replacePlaceholders(['service' => $data])
            ->send();
          return true;

        }

      case 'package':

        if (!empty($data = self::getStorePackage($id))) {

          $order = new \order($data['orders_id']);
          $data['customers_id'] = $order->customer['id'];
          $data = self::getCommonNotificationData($data);

          if (CustomerEmail::checkExistsTemplate($tpl = 'OP_PACKAGE_' . strtoupper($action))) {
            CustomerEmail::fromTemplate($tpl, $data['customer']['languages_id'])
            ->withSender(OP_NOTIFICATIONS_NAME_FROM, OP_NOTIFICATIONS_BOOKING_EMAIL_FROM)
            ->withRecipient('', $data['customer']['customers_email_address'])
            ->replacePlaceholders(['package' => $data])
            ->send();
          if (strpos($action, 'remind') !== false) {
            db_update(self::$schema['package']['table'], [
              '@reminders' => 'reminders + 1',
            ], 'id = ' . db_input($id));
          }
            return true;
          }

        }

      default: return false;

    }

  }

  public static function getCommonNotificationData($data) {

    $data['store'] = self::getStore($data['op_stores_id']);
    $data['contact'] = self::getStoreDefaultContact($data['op_stores_id']);
    $data['customer'] = \customer::getCustomerInfoById($data['customers_id']);
    $data['store']['link'] = HTTPS_SERVER . '/' . self::getLanguages()[$data['customer']['languages_id']]['code'] . '/optical_partner_detail.php?partner=' . $data['store']['op_partners_id'] . '&store=' . $data['op_stores_id'];

    return $data;

  }


  /********** PACKAGE AND ORDER STATUSES **********/

  public static function setPackageStatus($id, $status, $aftershipID = null) {

    //  ON_THE_WAY + READY_FOR_PICKUP + DELIVERED ... $id = package:tracking_number
    //  PICKED_UP + CANCELLED + RETURNED ... $id = op_stores_packages:id

    switch ($status) {

      case self::PACKAGE_STATUS_ON_THE_WAY:
        foreach (self::getStorePackagesByTrackingNumber($id) as $k => $id) {
          db_update(self::$schema['package']['table'], [
            'status' => $status,
            'aftership_id' => db_input($aftershipID),
            'updated_at' => 'now()',
          ], 'id = ' . db_input($id));
          self::createHistory([
            'entity_id' => db_input($id),
            'entity_type' => 'package',
            'field' => 'status',
            'value' => $status,
          ]);
        }
        break;

      case self::PACKAGE_STATUS_READY_FOR_PICKUP:
        foreach (self::getStorePackagesByTrackingNumber($id) as $k => $id) {
          db_update(self::$schema['package']['table'], [
            'status' => $status,
            'updated_at' => 'now()',
          ], 'id = ' . db_input($id));
          self::createHistory([
            'entity_id' => db_input($id),
            'entity_type' => 'package',
            'field' => 'status',
            'value' => $status,
          ]);
          self::sendNotification($id, 'package', 'arrival');
        }
        break;

      case self::PACKAGE_STATUS_DELIVERED:
        foreach (self::getStorePackagesByTrackingNumber($id) as $k => $id) {
          db_update(self::$schema['package']['table'], [
            'status' => $status,
            'updated_at' => 'now()',
          ], 'id = ' . db_input($id));
          self::createHistory([
            'entity_id' => db_input($id),
            'entity_type' => 'package',
            'field' => 'status',
            'value' => $status,
          ]);
          self::setOrderStatus($id);
        }
        break;

      case self::PACKAGE_STATUS_PICKED_UP:
        db_update(self::$schema['package']['table'], [
          'status' => $status,
          'updated_at' => 'now()',
        ], 'id = ' . db_input($id));
        self::createHistory([
          'entity_id' => db_input($id),
          'entity_type' => 'package',
          'field' => 'status',
          'value' => $status,
        ]);
        self::setOrderStatus($id);
        break;

      case self::PACKAGE_STATUS_CANCELLED:
      case self::PACKAGE_STATUS_RETURNED:
        db_update(self::$schema['package']['table'], [
          'status' => $status,
          'updated_at' => 'now()',
        ], 'id = ' . db_input($id));
        self::createHistory([
          'entity_id' => db_input($id),
          'entity_type' => 'package',
          'field' => 'status',
          'value' => $status,
        ]);
        self::setOrderStatus($id);
        break;

      default:
        break;

    }

    return true;

  }

  public static function getStorePackagesByTrackingNumber($trackingNumber) {
    $sql = '
      SELECT osp.id
      FROM ' . self::$schema['package']['table'] . ' osp
      JOIN package p ON p.package_id = osp.package_id AND p.orders_id = osp.orders_id
      WHERE
        osp.deleted_at IS NULL
        AND p.tracking_number = "' . db_input($trackingNumber) . '"';
    return db_get_single_values_array($sql);
  }

  public static function createStorePackage($packageId, $orderId) {
      $storeOrderId = db_get_single_value('
        SELECT id
        FROM '.self::$schema['order']['table'].'
        WHERE orders_id = '.db_input($orderId)
      );
      $data = [
        'status' => self::PACKAGE_STATUS_ON_THE_WAY,
        'op_stores_orders_id' => $storeOrderId,
        'orders_id' => $orderId,
        'package_id' => $packageId,
        'created_at' => 'now()',
      ];
      db_insert(self::$schema['package']['table'], self::sanitizeEntries($data));
  }

  public static function setOrderStatus($opStoresPackagesId) {
      $data = self::getStorePackage($opStoresPackagesId);
      $packages = self::getOrderPackageInfo($data['orders_id']);

      $statusClosed = true;
      foreach($packages as $package) {
          if (!in_array($package['status'], [self::PACKAGE_STATUS_DELIVERED, self::PACKAGE_STATUS_PICKED_UP, self::PACKAGE_STATUS_RETURNED])) {
              $statusClosed = false;
              break;
          }
      }

      if($statusClosed) {
          db_update(self::$schema['order']['table'], ['status' => self::ORDER_STATUS_CLOSED], 'orders_id = '.db_input($data['orders_id']));
          self::createHistory([
            'entity_id' => db_input($data['orders_id']),
            'entity_type' => 'order',
            'field' => 'status',
            'value' => self::ORDER_STATUS_CLOSED,
          ]);
      }
  }


  /********** REPORTS, STATISTICS, OVERVIEWS **********/

  public static function getStatistics($id, $scope, $period = 0) {

    foreach (self::$scopes[$scope]['set'] as $k => $v) {
      $data[$v . 's'] = db_get_single_value('SELECT COUNT(*) FROM ' . self::$schema[$v]['table'] . ' so WHERE so.deleted_at IS NULL AND so.' . self::$scopes[$scope]['field'] . ' = ' . db_input($id) . (empty($period) ? '' : self::getPeriodCondition($period)));
    }

    return $data;

  }

  public static function getCustomersRecords() {

    $sql = '
      SELECT
        sc.*,
        CONCAT(c.customers_firstname, " ", c.customers_lastname) AS name,
        c.customers_email_address AS email,
        COUNT(so.orders_id) AS orders,
        ps.name AS store
      FROM ' . self::$schema['customer']['table'] . ' sc
      JOIN customers c USING(customers_id)
      LEFT JOIN ' . self::$schema['order']['table'] . ' so USING(customers_id)
      LEFT JOIN ' . self::$schema['store']['table'] . ' ps ON ps.id = sc.op_stores_id
      WHERE
        sc.deleted_at IS NULL
        AND sc.ends_at IS NULL
        AND so.deleted_at IS NULL
      GROUP BY sc.customers_id
      ORDER BY orders DESC';

    return db_get_assoc_key($sql);

  }

  public static function getStoresRecords() {

    $data = [];

    foreach (self::getAllPartners(true) as $k => $v) {
      $data += self::getPartnersStores($k, false, true);
    }

    return $data;

  }

  public static function getReportData($id, $scope, $period = 0, $page = 1) {

    $sql = '
      SELECT
        so.*,
        DATE_FORMAT(so.created_at, "%m/%Y") AS period,
        IF(so.commission_calc <> so.commission_diff, 1, 0) AS clearance,
        CASE
          WHEN commission_diff > 0 THEN "posit"
          WHEN commission_diff < 0 THEN "negat"
          ELSE "ambiv"
        END AS outcome,
        CONCAT(c.customers_firstname, " ", c.customers_lastname) AS customer,
        ps.name AS store
      FROM ' . self::$schema['order']['table'] . ' so
      LEFT JOIN ' . self::$schema['store']['table'] . ' ps ON ps.id = so.op_stores_id
      LEFT JOIN customers c USING(customers_id)
      WHERE
        so.deleted_at IS NULL
        ' . (empty($period) ? '' : self::getPeriodCondition($period)) . '
        ' . (empty($id) ? '' : 'AND so.' . self::$scopes[$scope]['field'] . ' = ' . db_input($id)) . ' 
      ORDER BY period DESC, so.created_at DESC';

    $result['count'] = db_num_rows(db_query($sql));
    $sql = $sql . ' LIMIT ' . (($page * OP_RECORDS_PER_PAGE) - OP_RECORDS_PER_PAGE) . ', ' . OP_RECORDS_PER_PAGE;

    foreach ($result['data'] = db_get_assoc_key($sql) as $k => $v) {
      foreach ($tmp = self::getAccountingOrder($k)['items'] as $x => $y) {
        $result['contents'][$k][$x] = [
          'qty' => $y['products_quantity'],
          'name' => $y['products_name'],
          'price' => round($y['products_price'], 2),
          'commission' => round($y['amount'], 2)
        ]; 
      }
    }

    return $result;

  }

  public static function getGrossValues($id, $scope, $period = 0) {

    $sql = '
      SELECT
        CONCAT("CHF ", ROUND(SUM(order_total), 2)) AS orders_amount,
        CONCAT("CHF ", ROUND(SUM(commission_diff), 2)) AS commissions_amount
      FROM ' . self::$schema['order']['table'] . ' so
      WHERE so.deleted_at IS NULL AND so.' . self::$scopes[$scope]['field'] . ' = ' . db_input($id) . (empty($period) ? '' : self::getPeriodCondition($period));

    return db_get_single_row($sql);

  }

  public static function getRelatedPeriods($id, $scope) {

    $sql = '
      SELECT DATE_FORMAT(created_at, "%m/%Y") AS periods
      FROM ' . self::$schema['order']['table'] . '
      WHERE deleted_at IS NULL AND ' . self::$scopes[$scope]['field'] . ' = ' . db_input($id) . '
      GROUP BY YEAR(created_at), MONTH(created_at) DESC';

    return db_get_single_values_array($sql);

  }

  public static function checkReportInputs($record, $scope) {

    if (!in_array($scope, array_keys(self::$scopes))) {
      \messageStack::addSession(sprintf(t('OP_REPORTS_MSG_UNSUPPORTED_SCOPE'), $scope), \messageStack::TYPE_ERROR);
      return false;
    }

    if (!empty($record)) {

      switch ($scope) {      
        case 'customer':
          $record = db_get_single_value('SELECT id FROM ' . self::$schema['customer']['table'] . ' WHERE customers_id = ' . db_input($record));
          break;
        case 'search':
          $record = db_get_single_value('SELECT id FROM ' . self::$schema['order']['table'] . ' WHERE orders_id = ' . db_input($record));
          break;
      }

      if (!$record || !self::checkExistence($record, $scope === 'search' ? 'order' : $scope)) {
        switch ($scope) {
          case 'search':
            \messageStack::addSession(sprintf(t('OP_REPORTS_MSG_NO_SEARCH_RESULTS'), $record, $scope), \messageStack::TYPE_ERROR);
          break;
          default:
            \messageStack::addSession(sprintf(t('OP_REPORTS_MSG_SCOPE_RECORD_MISMATCH'), $record, $scope), \messageStack::TYPE_ERROR);
            break;
        }
        return false;
      }

    }

    return true;

  }

}