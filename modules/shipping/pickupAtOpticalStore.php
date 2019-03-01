<?php

use App\OpticalPartners\OpticalPartners as OP;

/**
 * Class pickupAtOpticalStore
 * Delivery method for opticalPartners orders
 */
class pickupAtOpticalStore extends modules {

  var $code, $title, $description, $icon, $enabled;
  var $status_constant = 'MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_STATUS';

  // class constructor
  function __construct($order = null) {
    $this->code = get_class($this);
    $this->title = t('MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_TEXT_TITLE');
    $this->description = t('MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_TEXT_DESCRIPTION');
    $this->sort_order = MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_SORT_ORDER;
    $this->icon = '';

    if (MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_STATUS == 'true' && customer::$customer_id) {
      $storeId = 0;
      if (isset($_SESSION[OP::SESSION_STORE])) {
        $storeId = $_SESSION[OP::SESSION_STORE];
      } else if (count(OP::getCustomerActiveAssignment(customer::$customer_id))) {
        $storeId = reset(OP::getCustomerActiveAssignment(customer::$customer_id));
      }
      if ($storeId && OP::checkIntegrity($storeId, 'store')) {
        $this->store = OP::getStore($storeId);
        $this->store['id'] = $storeId;
        $this->enabled = true;
      }
    }
  }

  // class methods
  function quote($order = null, $method = '') {
    $this->quotes = [];
    $this->quotes['id'] = $this->code;
    $this->quotes['module'] = $this->title;
    $storeLink = '<a href="' . tep_href_link("optical_partner_detail.php", "partner=" . $this->store['op_partners_id'] . "&store=" . $this->store['id'] . "#/contact") . '" target="_blank">' . $this->store['name'] . '</a>';

    $this->quotes['methods'][] = [
      'id' => $this->code,
      'title' => t('MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_TEXT_WAY') . $storeLink,
      'cost' => currencies::format(MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_COST, true, '', '', true, true, false, false, null, false),
    ];

    if (tep_not_null($this->icon)) {
      $this->quotes['icon'] = tep_image($this->icon, $this->title);
    }

    return $this->quotes;
  }

  function default_keys_config() {
    return [
      'MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_STATUS' => [
        'configuration_title' => 'Enable Pick up at Optical Store shipping',
        'configuration_value' => 'true',
        'configuration_description' => "Do you want to offer Pick up at Optical Store rate shipping?",
        'configuration_group_id' => '6',
        'sort_order' => '0',
        'set_function' => 'tep_cfg_select_option(array(\'true\', \'false\'), ',
      ],
      'MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_COST' => [
        'configuration_title' => 'Shipping Cost',
        'configuration_value' => '0.00',
        'configuration_description' => "The shipping cost for all orders using this shipping method.",
        'configuration_group_id' => '6',
        'sort_order' => '0',
      ],
      'MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_SORT_ORDER' => [
        'configuration_title' => 'Sort order of display.',
        'configuration_value' => '0',
        'configuration_description' => "Sort order of display. Lowest is displayed first.",
        'configuration_group_id' => '6',
        'sort_order' => '11',
      ],
    ];
  }

}
