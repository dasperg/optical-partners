<?php

class InstallBrand_PL_optical_partners extends moduleInstallBrands
{

    var $dependBrandModules = ['bulk_customers'];

    protected static $tables = [
      'op_customers_measurements',
      'op_descriptions',
      'op_partners',
      'op_partners_stores',
      'op_stores_bookings',
      'op_stores_commissions',
      'op_stores_contacts',
      'op_stores_customers',
      'op_stores_hours',
      'op_stores_services',
      'op_history',
      'op_stores_packages',
      'op_stores_orders',
    ];

    protected $aDefTranslations = [
      [
        'page' => ['common' => ['admin', 'customer']],
        'html' => 0,
        'tr' =>[

            /* COMMON */
          'BOX_OPTICAL_PARTNERS' => 'Optical partners',
          'OP_BREADCRUMB_START' => 'Our Partners',
          'OP_MY_STORE' => 'My store',
          'OP_STORE_ASSIGNMENT' => 'Assignment to Optical Store',
          'OP_MSG_REQUIRED_FIELDS' => 'Fields marked with (*) are required.',
          'OP_MSG_DELETE_PROMPT' => 'Are you sure you want to delete this entry?',

            /* HOURS */
          'OP_HOUR_DAY_1' => 'Monday',
          'OP_HOUR_DAY_2' => 'Tuesday',
          'OP_HOUR_DAY_3' => 'Wednesday',
          'OP_HOUR_DAY_4' => 'Thursday',
          'OP_HOUR_DAY_5' => 'Friday',
          'OP_HOUR_DAY_6' => 'Saturday',
          'OP_HOUR_DAY_7' => 'Sunday',
          'OP_HOUR_GENERAL' => 'Opening hours',
          'OP_HOUR_REGULAR' => 'Regular opening hours',
          'OP_HOUR_SPECIAL' => 'Special opening hours',
          'OP_HOUR_CLOSED' => 'Closed',

            /* DESCRIPTIONS & SECTIONS */
          'OP_SECTION_ABOUT' => 'About us',
          'OP_SECTION_CONTROL' => 'Lens control',
          'OP_SECTION_TEAM' => 'Team & Certificates',
          'OP_SECTION_BOOKING' => 'Booking',
          'OP_SECTION_CONTACT' => 'Contact',

            /* SERVICES */
          'OP_SERVICE_NAME' => 'Service name',
          'OP_SERVICE_DURATION' => 'Duration',
          'OP_SERVICES_TITLE' => 'About optical services',
          'OP_SERVICE_1' => [
            'en' => 'Contact Lens Consultation',
            'de' => 'Kontaktlinsen Beratung',
            'fr' => 'Lentilles de Contact Consultation',
          ],
          'OP_SERVICE_2' => [
            'en' => 'Contact Lens First Fitting',
            'de' => 'Kontaktlinsen Erstanpassung',
            'fr' => 'Premier Adapation De Lentilles',
          ],
          'OP_SERVICE_3' => [
            'en' => 'Contact Lens Check Up',
            'de' => 'Kontaktlinsen Nachkontrolle',
            'fr' => 'Control De Lentilles',
          ],
          'OP_SERVICE_4' => [
            'en' => 'Eye Control / Vision Check',
            'de' => 'Augenkontrolle / Sehtest',
            'fr' => 'Control Des Yeux / Test De Vue',
          ],
          'OP_SERVICE_5' => [
            'en' => '3D Vision Check',
            'de' => '3D Text De Vue',
            'fr' => '3D Sehtest',
          ],
          'OP_SERVICE_6' => [
            'en' => 'Other (please specify)',
            'de' => 'Sonstiges (bitte angeben)',
            'fr' => 'Autre (veuillez préciser)',
          ],
          'MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_TEXT_TITLE' => 'Pick up at Optical Store',
          'MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_TEXT_DESCRIPTION' => 'Pick up at Optical Store shipping method',
          'MODULE_SHIPPING_PICKUP_AT_OPTICAL_STORE_TEXT_WAY' => 'Pick up at Optical Store: ',

          // OP admin ajax request Ajax_Customers
          'OP_STORE_MANAGER_VALID' => 'Entered account is approved for store manager.',
          'OP_STORE_MANAGER_INVALID' => 'Sorry, given email address is not valid, account is either already used or does not exist.',
        ],
      ],
      [
        'page' => ['common' => 'customer'],
        'html' => 0,
        'tr' => [

            /* BOOKING - COMMON FOR CUSTOMER AND PARTNER */
          'OP_MSG_ORDER_ON_BEHALF_INFO' => 'INFO: Now you are buying on behalf of customer: ',
          'OP_MSG_ORDER_ON_BEHALF_SUCCESS' => 'INFO: Ordering on behalf of customer was successfull.',
          'OP_BOOKING_MSG_LOGIN_REQUIRED' => 'Sorry, booking of optical service is available for logged in customers only.',
          'OP_BOOKING_MSG_BRAND_REQUIRED' => 'Sorry, only regular MrLens customers are allowed book of optical service.',
          'OP_BOOKING_NO_OPENING_HOURS' => 'Sorry, this store does not have any opening hours specified,',
          'OP_BOOKING_NO_SERVICES' => 'Sorry, this store does not have any optical services specified.',
          'OP_BOOKING_LOGIN' => 'Login',
          'OP_BOOKING_REGISTER' => 'Register',
          'OP_BOOKING_STEP_1' => 'Type of optical service',
          'OP_BOOKING_STEP_2' => 'Date and time',
          'OP_BOOKING_STEP_3' => 'Booking review',
          'OP_BOOKING_INFO' => 'Select type of optical service you would like to book.',
          'OP_BOOKING_LEARN_MORE' => 'Learn more',
          'OP_BOOKING_SERVICE' => 'Optical service',
          'OP_BOOKING_SERVICE_PROMPT' => 'Choose from optical services',
          'OP_BOOKING_SERVICE_DURATION' => 'Duration',
          'OP_BOOKING_SERVICE_MINUTES' => 'minutes',
          'OP_BOOKING_SERVICE_PRICE' => 'Price (CHF)',
          'OP_BOOKING_LOGIN_PROMPT' => 'Please, login first.',
          'OP_BOOKING_DATE' => 'Date',
          'OP_BOOKING_TIME' => 'Time',
          'OP_BOOKING_TYPE_PROMPT' => 'Select date and time of appointment',
          'OP_BOOKING_DATETIME' => 'Date and time of appointment',
          'OP_BOOKING_TIME_PROMPT' => 'You have to select a time range',
          'OP_BOOKING_LEGEND_OCCUPIED' => 'Not available',
          'OP_BOOKING_LEGEND_SELECTED' => 'Selected',
          'OP_BOOKING_LEGEND_FREE' => 'Free',
          'OP_BOOKING_REMARK' => 'Remark',
          'OP_BOOKING_SUBMIT' => 'Book optical service',
          'OP_BOOKING_SUCCESS' => 'Your appointment has been successfully created!',
          'OP_BOOKING_SUCCESS_INFO' => 'We will send you a reminder so you won\'t forget for your appointment.',
          'OP_MY_BOOKINGS' => 'My bookings',
          'OP_MY_MEASUREMENTS' => 'My measurements',
          'OP_CURRENCY_CHF' => 'CHF',

            /* PARTNER ADMIN AREA */
          'OP_ORDER_STATUS' => 'Order status',
          'OP_ORDER_STATUS_OPEN' => 'Open',
          'OP_ORDER_STATUS_CLOSED' => 'Closed',
          'OP_PACKAGE_ON_THE_WAY' => 'On the way',
          'OP_PACKAGE_READY_FOR_PICKUP' => 'Ready for pickup',
          'OP_PACKAGE_DELIVERED' => 'Delivered',
          'OP_PACKAGE_PICKED_UP' => 'Picked up',
          'OP_PACKAGE_CANCELLED' => 'Cancelled',
          'OP_PACKAGE_RETURNED' => 'Returned',
          'OP_PACKAGE_CONFIRM_PICKUP' => 'Confirm pickup by customer.',
          'OP_PACKAGE_DELIVERED_TO_CUSTOMER_ON' => 'Delivered to customer on',
          'OP_PACKAGE_PICKED_UP_BY_CUSTOMER_ON' => 'Picked up by customer on',
          'OP_FE_ADMIN_LOGOUT' => 'Logout',
          'OP_FE_ADMIN_DETAILS' => 'Details',
          'OP_FE_ADMIN_MY_CUSTOMERS' => 'Customers',
          'OP_FE_ADMIN_ACCOUNTING' => 'Accounting',
          'OP_FE_ADMIN_ORDERS' => 'Orders',
          'OP_FE_ADMIN_BOOKING' => 'Bookings',
          'OP_FE_ADMIN_ACCOUNT_DISABLED' => 'Sorry, your Partner / Store account is disabled.',
          'OP_MSG_INTEGRITY_ERROR' => 'Oops, something went wrong. We can not find requested partner. Please, contact our customer service via email (info@mrlens.ch) or phone (+41 41 741 28 87) to help you resolve this issue.',
          'OP_MSG_CREATE_CUSTOMER_SUCCESS' => 'Customer was successfully created and assigned to your store.',
        ],
      ],
      [
        'page' => ['/op_admin_details.php' => 'customer'],
        'html' => 0,
        'tr' => [
          'OP_DETAILS_STORE_STATISTICS' => 'Store statistics',
          'OP_DETAILS_STORE_DETAILS' => 'Store details',
          'OP_DETAILS_STORE_STATS_MEASUREMENTS' => 'Measurements',
          'OP_DETAILS_STORE_STATS_SERVICES' => 'Services',
          'OP_DETAILS_STORE_STATS_CUSTOMERS' => 'Customers',
          'OP_DETAILS_STORE_STATS_BOOKINGS' => 'Bookings',
          'OP_DETAILS_STORE_STATS_ORDERS' => 'Orders',
          'OP_DETAILS_BASIC' => 'Basic',
          'OP_DETAILS_STORE_NAME' => 'Name',
          'OP_DETAILS_WEBSITE' => 'Website',
          'OP_DETAILS_LOCATION' => 'Location',
          'OP_DETAILS_ADDRESS' => 'Address',
          'OP_DETAILS_CONTACT' => 'Contact',
          'OP_DETAILS_ACCOUNTING' => 'Accounting',
          'OP_DETAILS_BUSINESS_ID' => 'Business ID',
          'OP_DETAILS_BANK_NAME' => 'Bank name',
          'OP_DETAILS_ACCOUNT_NAME' => 'Account name',
          'OP_DETAILS_ACCOUNT_IBAN' => 'Account IBAN',
        ],
      ],
      [
        'page' => ['/op_admin_customers.php' => 'customer'],
        'html' => 0,
        'tr' => [
          'OP_CUSTOMER_SEARCH' => 'Search in my customers',
          'OP_CUSTOMER_SEARCH_OVER_BRAND' => 'Search in all customers',
          'OP_CUSTOMER_BTN_SEARCH' => 'Search',
          'OP_CUSTOMER_BTN_BACK' => 'Back',
          'OP_CUSTOMER_BTN_CREATE_CUSTOMER' => 'Create customer',
          'OP_CUSTOMER_BTN_CONFIRM' => 'Confirm',
          'OP_CUSTOMER_BTN_CANCEL' => 'Cancel',
          'OP_CUSTOMER_BTN_ASSIGN_CUSTOMER' => 'Assign',
          'OP_CUSTOMER_BTN_TAKE_OVER_CUSTOMER' => 'Take over',
          'OP_CUSTOMER_TAKE_OVER_CUSTOMER_PROMPT' => 'We confirm that the customer was in store with us and that we conducted a chargeable follow-up.',
          'OP_CUSTOMER_FIRST_NAME' => 'First name',
          'OP_CUSTOMER_LAST_NAME' => 'Last name',
          'OP_CUSTOMER_ADDRESS' => 'Address',
          'OP_CUSTOMER_EMAIL' => 'E-mail',
          'OP_CUSTOMER_PHONE' => 'Phone number',
          'OP_CUSTOMER_CITY' => 'City',
          'OP_CUSTOMER_ASSIGNED_SINCE' => 'Assigned since',
          'OP_CUSTOMER_LIST' => 'List of my customers',
          'OP_CUSTOMER_LIST_ALL' => 'Show all',
          'OP_CUSTOMER_LIST_ACTIVE' => 'Show active only',
          'OP_CUSTOMER_DETAIL' => 'Detail',
          'OP_CUSTOMER_MAKE_ORDER' => 'Make order',
          'OP_CUSTOMER_SHOW_DETAIL' => 'Show details',
          'OP_CUSTOMER_NO_RESULTS' => 'No customers found',
          'OP_CUSTOMER_NO_ORDERS' => 'No orders',
          'OP_CUSTOMER_NO_MEASUREMENTS' => 'No measurements',
          'OP_CUSTOMER_MENU_DETAILS' => 'Customer details',
          'OP_CUSTOMER_MENU_ORDERS' => 'Customer orders',
          'OP_CUSTOMER_BOOKING_CREATE' => 'Create booking',
          'OP_CUSTOMER_BOOKING_RESCHEDULE' => 'Reschedule booking',
          'OP_CUSTOMER_MENU_MEASUREMENTS' => 'Customer measurements',
          'OP_CUSTOMER_ORDER_NUMBER' => 'Order number',
          'OP_CUSTOMER_ORDER_TOTAL' => 'Order total',
          'OP_CUSTOMER_ORDER_DATE' => 'Order date',
          'OP_CUSTOMER_ORDER_STATUS' => 'Order status',
          'OP_CUSTOMER_ORDER_SHIPPING_ADDRESS' => 'Shipping address',
          'OP_CUSTOMER_ORDER_SHIPPING_METHOD' => 'Shipping method',
          'OP_CUSTOMER_ORDER_BILLING_ADDRESS' => 'Billing address',
          'OP_CUSTOMER_ORDER_BILLING_METHOD' => 'Billing method',
          'OP_CUSTOMER_ORDER_PRODUCTS' => 'Products',
          'OP_CUSTOMER_ORDER_QUANTITY' => 'Quantity',
          'OP_CUSTOMER_ORDER_PRICE' => 'Price',
          'OP_CUSTOMER_ORDER_VAT' => 'Tax',
          'OP_CUSTOMER_MEASUREMENT_DATE' => 'Date',
          'OP_CUSTOMER_MEASUREMENT_CONSULTANT' => 'Consultant',
          'OP_CUSTOMER_MEASUREMENT_CONSULTANT_HINT' => 'Please, enter name or choose from drop-down above.',
          'OP_CUSTOMER_MEASUREMENT_REMARK' => 'Remark',
          'OP_CUSTOMER_MEASUREMENT_SERVICE' => 'Optical service',
          'OP_CUSTOMER_MEASUREMENT_CREATE' => 'Add measurement',
          'OP_CUSTOMER_MEASUREMENT_SUBMIT' => 'Add',
          'OP_CUSTOMER_MEASUREMENT_CORRECTION' => 'Full correction',
          'OP_CUSTOMER_MEASUREMENT_LEFT' => 'Left eye',
          'OP_CUSTOMER_MEASUREMENT_RIGHT' => 'Right eye',
          'OP_CUSTOMER_MEASUREMENT_ATTR_SPH' => 'SPH',
          'OP_CUSTOMER_MEASUREMENT_ATTR_CYL' => 'CYL',
          'OP_CUSTOMER_MEASUREMENT_ATTR_AXS' => 'AXS',
          'OP_CUSTOMER_MEASUREMENT_ATTR_ADD' => 'ADD',
          'OP_CUSTOMER_MEASUREMENT_ATTR_HSA' => 'HSA',
          'OP_CUSTOMER_MEASUREMENT_ATTR_VCC' => 'VCC',
          'OP_CUSTOMER_MEASUREMENT_ATTR_SPHI' => 'Sphere',
          'OP_CUSTOMER_MEASUREMENT_ATTR_CYLI' => 'Cylinder',
          'OP_CUSTOMER_MEASUREMENT_ATTR_AXSI' => 'Axis',
          'OP_CUSTOMER_MEASUREMENT_ATTR_ADDI' => '',
          'OP_CUSTOMER_MEASUREMENT_ATTR_HSAI' => '',
          'OP_CUSTOMER_MEASUREMENT_ATTR_VCCI' => '',

          /* CUSTOMER - CREATE ADDRESS */
          'OP_CUSTOMER_NO_ADDRESS' => 'No address entry',
          'OP_CUSTOMER_ADDRESS_CREATE_HEADER' => 'Create address for customer',
          'OP_CUSTOMER_ADDRESS_OPTIONAL_FIELD' => 'Optional',
          'OP_CUSTOMER_ADDRESS_BTN_SUBMIT' => 'Create address',
          'OP_CUSTOMER_ADDRESS_MSG_SUCESS' => 'Customer address has been successfully created.',
          'OP_CUSTOMER_MSG_ORDER_NO_ADDRESS' => 'This customer does not have any address entry, or its address is incomplete. You can create new address via the form bellow.',
        ],
      ],
      [
        'page' => ['/op_admin_orders.php' => 'customer'],
        'html' => 0,
        'tr' => [
          'OP_ORDER_NUMBER' => 'Order number',
          'OP_ORDER_CUSTOMER' => 'Customer name',
          'OP_ORDER_DATE' => 'Order date',
          'OP_ORDER_TOTAL' => 'Order total',
          'OP_ORDER_STATUS' => 'Order status',
          'OP_ORDER_COMMISSION' => 'Commission',
          'OP_ORDER_COMMISSION_PAID' => 'Commisssion paid',
          'OP_ORDER_COMMISSION_PAID_DATE' => 'Paid date',
          'OP_ORDER_NO_ORDERS' => 'No orders',
          'OP_ORDER_TOTALS' => 'Totals',
          'OP_PACKAGE_TRACKING_ID' => 'Tracking ID',
          'OP_PACKAGE_CARRIER' => 'Carrier',
          'OP_PACKAGE_SERVICE_TYPE' => 'Service type',
          'OP_PACKAGE_EXTNUMBER' => 'Internal code',
          'OP_PACKAGE_STATUS' => 'Package status',
          'OP_PACKAGE_TRACKING_ID' => 'Tracking number',
          'OP_PACKAGE_CARRIER' => 'Postal career',
          'OP_PACKAGE_EXTNUMBER' => 'Internal code',
          'OP_PACKAGE_STATUS' => 'Package status',
          'OP_ORDER_BTN_SEARCH' => 'Search'
        ],
      ],
      [
        'page' => ['/op_admin_bookings.php' => 'customer'],
        'html' => 0,
        'tr' => [
          'OP_APPOINTMENT' => 'Booking',
          'OP_APPOINTMENT_CUSTOMER' => 'Customer',
          'OP_APPOINTMENT_SERVICE' => 'Service',
          'OP_APPOINTMENT_DATE' => 'Date & Time',
          'OP_APPOINTMENT_REMARK' => 'Remark',
          'OP_APPOINTMENT_DURATION' => 'Duration',
          'OP_APPOINTMENT_DURATION_IN_MINUTES' => 'minutes',
          'OP_APPOINTMENT_NO_BOOKINGS' => 'No bookings',
          'OP_APPOINTMENT_UPCOMING' => 'Upcoming bookings',
          'OP_APPOINTMENT_PAST' => 'Past bookings',
          'OP_APPOINTMENT_CALENDAR' => 'Calendar',
          'OP_APPOINTMENT_EDIT' => 'Edit',
          'OP_APPOINTMENT_HEADING' => 'Edit booking',
          'OP_APPOINTMENT_DETAILS' => 'Details',
          'OP_APPOINTMENT_ACTIONS' => 'Actions',
          'OP_APPOINTMENT_CUSTOMER_ATTENDANCE' => 'Customer attendance',
          'OP_APPOINTMENT_CUSTOMER_ATTENDANCE_ON' => 'Attendance confirmed on',
          'OP_APPOINTMENT_RESCHEDULE' => 'Reschedule',
          'OP_APPOINTMENT_RESCHEDULE_SUCCESS' => 'Appointment was successfully reschedulled.',
          'OP_APPOINTMENT_CHANGE' => 'Change',
          'OP_APPOINTMENT_CONFIRM' => 'Confirm',
          'OP_APPOINTMENT_UPDATE' => 'Update',
          'OP_APPOINTMENT_UPDATE_SUCCESS' => 'Appointment was successfully updated.',
          'OP_APPOINTMENT_CANCEL' => 'Cancel',
          'OP_APPOINTMENT_CANCELLED' => 'Cancelled',
          'OP_APPOINTMENT_CANCEL_PROMPT' => 'Are you sure you want to cancel this booking?',
          'OP_APPOINTMENT_CANCEL_SUCCESS' => 'Appointment was successfully cancelled.',
        ],
      ],
      [
        'page' => ['/op_customer_bookings.php' => 'customer'],
        'html' => 0,
        'tr' => [
          'OP_APPOINTMENT_NO_BOOKINGS' => 'You have no bookings yet.',
          'OP_APPOINTMENT_NO_MEASUREMENTS' => 'You have no measurements yet.',
          'OP_APPOINTMENT_STORE' => 'Store',
          'OP_APPOINTMENT_SERVICE' => 'Service',
          'OP_APPOINTMENT_DATE' => 'Date and time',
          'OP_APPOINTMENT_DURATION' => 'Duration',
          'OP_APPOINTMENT_REMARK' => 'Remark',
          'OP_APPOINTMENT_UPCOMING' => 'Upcoming bookings',
          'OP_APPOINTMENT_PAST' => 'Past bookings',
          'OP_APPOINTMENT_DETAILS' => 'Details',
          'OP_APPOINTMENT_CANCEL' => 'Cancel',
          'OP_APPOINTMENT_CANCEL_PROMPT' => 'Are you sure you want to cancel this appointment?',
          'OP_APPOINTMENT_CANCEL_SUCCESS' => 'Appointment was successfully cancelled.',
          'OP_APPOINTMENT_CONFIRM' => 'Confirm',
          'OP_APPOINTMENT_CANCELLED' => 'Cancelled',
          'OP_MEASUREMENT_DATE' => 'Date and time',
          'OP_MEASUREMENT_SERVICE' => 'Service',
          'OP_MEASUREMENT_CONSULTANT' => 'Consultant',
          'OP_APPOINTMENT_ACTIONS_AND_REMARK' => 'Actions and remarks',
          'OP_APPOINTMENT_RESCHEDULE' => 'Reschedule',
          'OP_CUSTOMER_MEASUREMENT_CORRECTION' => 'Full correction',
          'OP_CUSTOMER_MEASUREMENT_LEFT' => 'Left eye',
          'OP_CUSTOMER_MEASUREMENT_RIGHT' => 'Right eye',
          'OP_CUSTOMER_MEASUREMENT_ATTR_SPH' => 'SPH',
          'OP_CUSTOMER_MEASUREMENT_ATTR_CYL' => 'CYL',
          'OP_CUSTOMER_MEASUREMENT_ATTR_AXS' => 'AXS',
          'OP_CUSTOMER_MEASUREMENT_ATTR_ADD' => 'ADD',
          'OP_CUSTOMER_MEASUREMENT_ATTR_HSA' => 'HSA',
          'OP_CUSTOMER_MEASUREMENT_ATTR_VCC' => 'VCC',
          'OP_CUSTOMER_MEASUREMENT_ATTR_SPHI' => 'Sphere',
          'OP_CUSTOMER_MEASUREMENT_ATTR_CYLI' => 'Cylinder',
          'OP_CUSTOMER_MEASUREMENT_ATTR_AXSI' => 'Axis',
          'OP_CUSTOMER_MEASUREMENT_ATTR_ADDI' => '',
          'OP_CUSTOMER_MEASUREMENT_ATTR_HSAI' => '',
          'OP_CUSTOMER_MEASUREMENT_ATTR_VCCI' => '',
        ],
      ],
      [
        'page' => ['/op_admin_accounting.php' => 'customer'],
        'html' => 0,
        'tr' => [
          'OP_ACCOUNTING_PERIOD' => 'Period',
          'OP_ACCOUNTING_ORDERS' => 'Orders',
          'OP_ACCOUNTING_TOTAL' => 'Order totals',
          'OP_ACCOUNTING_COMMISSION' => 'Commission',
          'OP_ACCOUNTING_NO_ORDERS' => 'No orders',
          'OP_ACCOUNTING_CLEARANCE' => 'Clearance',
          'OP_CURRENT_PERIOD' => 'Current period',
          'OP_PREVIOUS_PERIODS' => 'Previous periods',
          'OP_ACCOUNTING_SUMMARY' => 'Summary',
          'OP_UNIT_PRICE' => 'Unit price',
          'OP_ORDER_TOTALS' => 'Total',
          'OP_ORDER_NUMBER' => 'Order number',
          'OP_ORDER_CUSTOMER' => 'Customer',
          'OP_ORDER_STATUS' => 'Order status',
          'OP_ORDER_DATE' => 'Date',
          'OP_ORDER_TOTAL' => 'Order total',
          'OP_ORDER_COMMISSION' => 'Commission',
        ],
      ],
      [
        'page' => ['/optical_services.php' => 'customer'],
        'html' => 1,
        'tr' => [
            /* PREDEFINED SERVICES / DESCRPTIONS */
          'OP_SERVICES_INTRO' => 'About optical services / Description',
          'OP_SERVICES_BTN_BACK' => 'Back',
          'OP_SERVICE_1_INFO' => 'Service 1 description',
          'OP_SERVICE_2_INFO' => 'Service 2 description',
          'OP_SERVICE_3_INFO' => 'Service 3 description',
          'OP_SERVICE_4_INFO' => 'Service 4 description',
          'OP_SERVICE_5_INFO' => 'Service 5 description',
        ],
      ],
      [
        'page' => ['/optical_partners_overview.php' => 'customer'],
        'html' => 0,
        'tr' => [
          'OP_HEADING_TITLE' => 'MrLens Partner Fillialen',
          'OP_HEADING_DESCRIPTION' => 'Sirloin boudin porchetta flank, swine cow biltong ribeye jerky turkey tenderloin. Alcatra doner fatback brisket swine jerky. Frankfurter chicken tri-tip kielbasa jowl, picanha sirloin cow shank chuck kevin turducken rump burgdoggen pork.',
          'OP_NO_STORES_FOUND' => 'Sorry, no partners have been found.',
          'OP_GOTO_STORE' => 'Visit partner site',
          'OP_OVERVIEW_SEARCH' => 'Search for address',
        ],
      ],
      [
        'page' => ['/admin/optical_partners.php' => 'admin'],
        'html' => 0,
        'tr' => [
          'HEADING_TITLE' => 'Optical partners / Management',

            /* COMMON */
          'OP_ID' => 'ID',
          'OP_NAME' => 'Name',
          'OP_STATUS' => 'Status',
          'OP_COMMISSION' => 'Commission (%)',
          'OP_COMMISSIONS' => 'Commissions',
          'OP_COMMISSION_GROUP' => 'Commission group',
          'OP_COMMISSION_PERCENTAGE' => '%',
          'OP_COMMISSION_PRODUCT_TYPES' => 'Product types',
          'OP_COMMISSION_EXCLUDED_PRODUCT_BRANDS' => 'Excluded product brands',
          'OP_COMMISSION_INVALID' => 'Invalid commission value. Please enter number between 0 - 99.',
          'OP_CREATED' => 'Created',
          'OP_MODIFIED' => 'Modified',
          'OP_NO_RESULTS' => 'No results',
          'OP_NO_IMAGE' => 'No image',
          'OP_MANAGE_PARTNERS' => 'Manage optical partners',

            /* TABS */
          'OP_TAB_DETAILS' => 'Details',
          'OP_TAB_STORES' => 'Stores',
          'OP_TAB_CONTACTS' => 'Contacts',
          'OP_TAB_SERVICES' => 'Services',
          'OP_TAB_HOURS' => 'Opening hours',
          'OP_TAB_DESCRIPTIONS' => 'Descriptions',
          'OP_TAB_ACCOUNTING' => 'Accounting',

            /* OPTICAL PARTNERS */
          'OP_OPTICAL_PARTNER' => 'Optical partner',
          'OP_OPTICAL_PARTNERS' => 'Optical partners',
          'OP_ADD_PARTNER' => 'Add partner',

            /* SERVICES */
          'OP_OPTICAL_SERVICE' => 'Optical service',
          'OP_OPTICAL_SERVICES' => 'Optical services',
          'OP_ADD_SERVICE' => 'Add service',
          'OP_SERVICE_NAME' => 'Service name',
          'OP_SERVICE_DURATION' => 'Duration',
          'OP_SERVICE_PRICE' => 'Price (CHF)',
          'OP_SERVICE_PRICE_INVALID' => 'Please specify a valid amount (Example: 27.50).',
          'OP_SERVICES_HELP' => 'Fill in a new service, or choose one from predefined services.',

            /* STORES */
          'OP_STORE' => 'Store',
          'OP_STORES' => 'Stores',
          'OP_STORES_ENABLED' => 'Active stores',
          'OP_STORES_DISABLED' => 'Inactive stores',
          'OP_STORE_FIELDSET_BASIC' => 'Basic',
          'OP_STORE_FIELDSET_LOCATION' => 'Location',
          'OP_STORE_FIELDSET_ACCOUNTING' => 'Accounting',
          'OP_STORE_LOGO' => 'Logo',
          'OP_STORE_IMAGE' => 'Top image',
          'OP_STORE_NAME' => 'Name',
          'OP_STORE_STREET' => 'Street',
          'OP_STORE_ZIP' => 'ZIP code',
          'OP_STORE_CITY' => 'City',
          'OP_STORE_LOCATION' => 'Coordinates',
          'OP_STORE_WEBSITE' => 'Website',
          'OP_STORE_REGISTER_NAME' => 'Register name',
          'OP_STORE_VAT_ID' => 'VAT ID',
          'OP_STORE_BUSINESS_ID' => 'Business ID',
          'OP_STORE_BANK_NAME' => 'Bank name',
          'OP_STORE_BANK_ACCOUNT_IBAN' => 'Account IBAN',
          'OP_STORE_BANK_ACCOUNT_NAME' => 'Account name',
          'OP_STORE_ACCOUNTING_CONTACT' => 'Accountability',
          'OP_STORE_ACCOUNTING_CONTACT_HELP' => 'You need to create some store contacts first, in order to choose one of them here, as a responsible accounting person.',
          'OP_STORE_MANAGER' => 'Store manager',
          'OP_STORE_MANAGER_HELP' => 'Please, enter email address of existing customer.',
          'OP_STORE_MANAGER_CHANGE_PROMPT' => 'This is serious change, by which many related records will be transfered. Please confirm.',
          'OP_STORE_MANAGER_REMOVE_PROMPT' => 'You can not remove existing Store manager relation. You can only replace it with another.',

            /* CONTACTS */
          'OP_CONTACT' => 'Contact',
          'OP_CONTACTS' => 'Contacts',
          'OP_ADD_CONTACT' => 'Add contact',
          'OP_CONTACT_NAME' => 'Name',
          'OP_CONTACT_PHONE' => 'Phone',
          'OP_CONTACT_EMAIL' => 'E-mail',
          'OP_CONTACT_PRIVATE' => 'Private',
          'OP_CONTACT_NOT_SELECTED' => '--- Not selected ---',
          'OP_CONTACT_NO_CONTACTS' => 'No contacts available',

            /* HOURS */
          'OP_HOUR' => 'Hour',
          'OP_HOURS' => 'Hours',
          'OP_ADD_HOUR' => 'Add opening hours',
          'OP_ADD_HOUR_REGULAR' => 'Add regular opening hours',
          'OP_ADD_HOUR_SPECIAL' => 'Add special opening hours',
          'OP_HOUR_DATE' => 'Date',
          'OP_HOUR_SPECIAL_DATE_FROM' => 'Date from',
          'OP_HOUR_SPECIAL_DATE_TO' => 'Date to',
          'OP_HOUR_SPECIAL_REMARK' => 'Remark',
          'OP_HOUR_WEEKDAY' => 'Day',
          'OP_HOUR_WEEKDAYS' => 'Days',
          'OP_HOUR_STARTS_AT' => 'Starts at',
          'OP_HOUR_ENDS_AT' => 'Ends at',

            /* ACCOUNTING */
          'OP_ACCOUNTING_PERIOD' => 'Period',
          'OP_ACCOUNTING_INVOICE_NUMBER' => 'Invoice number',
          'OP_ACCOUNTING_ISSUED_ON' => 'Issues by store on',
          'OP_ACCOUNTING_PAID_ON' => 'Paid to store on',
          'OP_ACCOUNTING_COMMISSION' => 'Commission (CHF)',

            /* DESCRIPTIONS & SECTIONS */
          'OP_DESCRIPTION' => 'Description',
          'OP_DESCRIPTIONS' => 'Descriptions',
          'OP_CONTENT' => 'Content',

            /* BUTTONS & ACTIONS */
          'OP_BTN_ADD' => 'Add',
          'OP_BTN_CREATE' => 'Create',
          'OP_BTN_EDIT' => 'Edit',
          'OP_BTN_MANAGE' => 'Manage',
          'OP_BTN_UPDATE' => 'Update',
          'OP_BTN_DELETE' => 'Delete',
          'OP_BTN_CANCEL' => 'Cancel',
          'OP_BTN_SAVE' => 'Save',
          'OP_BTN_BACK' => 'Back',
          'OP_BTN_SUBMIT' => 'Submit',
          'OP_BTN_ENABLE' => 'Enable',
          'OP_BTN_DISABLE' => 'Disable',
          'OP_BTN_IMAGE_UPLOAD' => 'Upload image',
          'OP_BTN_IMAGE_CHANGE' => 'Change image',
          'OP_BTN_TOGGLE' => 'Disable all stores',

            /* MESSAGES */
          'OP_MSG_UNIVERSAL' => '%1$s was successfully %2$s.',
          'OP_MSG_INTEGRITY_ERROR' => 'Integrity error. Entity ID and entity type mismatch, unknown or not found.',
          'OP_MSG_TOGGLE' => 'All stores of selected partner were disabled.',
        ],
      ],
      [
        'page' => ['/admin/optical_partners_reports.php' => 'admin'],
        'html' => 0,
        'tr' => [
          'HEADING_TITLE' => 'Optical partners / Reports and overviews',
          'OP_REPORTS' => 'Reports and overviews',
          'OP_REPORTS_SCOPES' => 'Scopes',
          'OP_REPORTS_SCOPE' => 'Scope',
          'OP_REPORTS_SCOPE_PARTNERS' => 'Partners',
          'OP_REPORTS_SCOPE_STORES' => 'Stores',
          'OP_REPORTS_SCOPE_CUSTOMERS' => 'Customers',
          'OP_REPORTS_SCOPE_PARTNER' => 'Partners',
          'OP_REPORTS_SCOPE_STORE' => 'Stores',
          'OP_REPORTS_SCOPE_CUSTOMER' => 'Customers',
          'OP_REPORTS_SCOPE_SEARCH' => 'Search',
          'OP_REPORTS_RECORDS' => 'Records',
          'OP_REPORTS_RECORD' => 'Record',
          'OP_REPORTS_RECORDS_ALL' => 'All',
          'OP_REPORTS_RECORDS_SEARCH_HINT' => 'Enter order ID',
          'OP_REPORTS_PERIOD_FROM' => 'From',
          'OP_REPORTS_PERIOD_TO' => 'To',
          'OP_REPORTS_SUBMIT' => 'Submit',
          'OP_REPORTS_SEARCH' => 'Search',
          'OP_REPORTS_PERIOD' => 'Period',
          'OP_REPORTS_CURRENT_PERIOD' => 'Current period',
          'OP_REPORTS_PREVIOUS_PERIODS' => 'Previous periods',
          'OP_REPORTS_CLEARANCE' => 'Clearance',
          'OP_REPORTS_ORDERS' => 'Orders',
          'OP_REPORTS_ORDER_DATE' => 'Date',
          'OP_REPORTS_ORDER_STATUS' => 'Order status',
          'OP_REPORTS_ORDER_STATUS_OPEN' => 'Open',
          'OP_REPORTS_ORDER_STATUS_CLOSED' => 'Closed',
          'OP_REPORTS_ORDER_TOTALS' => 'Order totals',
          'OP_REPORTS_COMMISSION' => 'Commission',
          'OP_REPORTS_SUMMARY' => 'Summary',
          'OP_REPORTS_UNIT_PRICE' => 'Unit price',
          'OP_REPORTS_PARTNER' => 'Partner',
          'OP_REPORTS_STORE' => 'Store',
          'OP_REPORTS_CUSTOMER' => 'Customer',
          'OP_REPORTS_CUSTOMERS' => 'Customers',
          'OP_REPORTS_BOOKINGS' => 'Bookings',
          'OP_REPORTS_SERVICES' => 'Services',
          'OP_REPORTS_NO_PARTNERS' => 'No partners',
          'OP_REPORTS_NO_STORES' => 'No stores',
          'OP_REPORTS_NO_CUSTOMERS' => 'No customers',
          'OP_REPORTS_NO_RECORDS' => 'No records found',
          'OP_REPORTS_NO_ORDERS' => 'Sorry, no orders found for selected record.',
          'OP_CURRENCY_CHF' => 'CHF',
          'OP_ORDER_STATUS_OPEN' => 'Open',
          'OP_ORDER_STATUS_CLOSED' => 'Closed',
          'OP_REPORTS_STATISTICS' => 'Statistics',
          'OP_REPORTS_COUNT' => 'Count',
          'OP_REPORTS_COUNT_ORDERS' => 'Orders',
          'OP_REPORTS_COUNT_CUSTOMERS' => 'Customers',
          'OP_REPORTS_COUNT_BOOKINGS' => 'Appointments',
          'OP_REPORTS_COUNT_SERVICES' => 'Services',
          'OP_REPORTS_COUNT_MEASUREMENTS' => 'Measurements',
          'OP_REPORTS_COUNT_ORDERS_AMOUNT' => 'Orders / Amount',
          'OP_REPORTS_COUNT_COMMISSIONS_AMOUNT' => 'Commissions / Amount',
          'OP_REPORTS_ORDER_ID' => 'ID',
          'OP_REPORTS_ORDER_STATUS' => 'Status',
          'OP_REPORTS_ORDER_DATE' => 'Date',
          'OP_REPORTS_ORDER_CUSTOMER' => 'Customer',
          'OP_REPORTS_ORDER_STORE' => 'Optical store',
          'OP_REPORTS_ORDER_ON_BEHALF' => 'On behalf of customer',
          'OP_REPORTS_ORDER_TOTAL' => 'Order total (CHF)',
          'OP_REPORTS_ORDER_COMMISSION' => 'Commission (CHF)',
          'OP_REPORTS_ORDER_INVOICE' => 'Invoice',
          'OP_REPORTS_ORDER_INVOICE_BY_STORE' => 'Invoice by Optical Store',
          'OP_REPORTS_ORDER_INVOICE_ISSUED' => 'Issued by store on',
          'OP_REPORTS_ORDER_INVOICE_PAID' => 'Paid to store on',
          'OP_REPORTS_ORDER_ACTIONS' => 'Actions',
          'OP_REPORTS_ORDER_DETAIL' => 'Detail',
          'OP_REPORTS_ORDER_UNPAID' => 'Order unpaid',
          'OP_REPORTS_ORDER_CONTENT_HEADER' => 'Order content',
          'OP_REPORTS_ORDER_CONTENT_QTY' => 'Qty',
          'OP_REPORTS_ORDER_CONTENT_NAME' => 'Name',
          'OP_REPORTS_ORDER_CONTENT_UNIT_PRICE' => 'Unit price',
          'OP_REPORTS_ORDER_CONTENT_COMMISSION' => 'Commission',
          'OP_REPORTS_ORDER_CLEARANCE' => 'clearance',
          'OP_REPORTS_ORDER_CLEARANCE_INFO' => 'Clearance from previous period',
          'OP_REPORTS_VAT' => 'VAT',
          'OP_REPORTS_VAT_INFO' => 'All prices are exclusive of VAT',
          'OP_REPORTS_MSG_SCOPE_RECORD_MISMATCH' => 'Sorry, the requested record does not exist, or there\'s mismatch between record "%1$s" and scope "%2$s".',
          'OP_REPORTS_MSG_UNSUPPORTED_SCOPE' => 'Sorry, the requested scope "%s" is not supported.',
          'OP_REPORTS_MSG_NO_SEARCH_RESULTS' => 'Sorry, no such an order has been found.'
        ],
      ],
    ];

    public static function getDescription()
    {
        return 'Base install script for Optical Partners (OP).';
    }

    public function dbInstall()
    {

        $content = '';

        // DB migrations
        if (!$this->checkExistTable('op_partners')) {
            $this->brand->query(
              '
        CREATE TABLE `op_partners` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `name` VARCHAR(64) NOT NULL,
          `status` TINYINT(1) NOT NULL DEFAULT 1,
          `commission` TINYINT(2) NOT NULL DEFAULT 0,
          `created_at` DATETIME NOT NULL,
          `updated_at` DATETIME NOT NULL,
          `deleted_at` DATETIME DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_partners` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_partners_stores')) {
            $this->brand->query(
              '
        CREATE TABLE `op_partners_stores` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `op_partners_id` INT(11) NOT NULL,
          `status` TINYINT(1) NOT NULL DEFAULT 0,
          `name` VARCHAR(64) NOT NULL,
          `logo` VARCHAR(64) NOT NULL,
          `image` VARCHAR(64) NOT NULL,
          `website` VARCHAR(128) NOT NULL,
          `street` VARCHAR(64) NOT NULL,
          `city` VARCHAR(32) NOT NULL,
          `zip` VARCHAR(16) NOT NULL,
          `countries_id` INT(11) NOT NULL,
          `location` VARCHAR(64) NOT NULL,
          `register_name` VARCHAR(64) NOT NULL,
          `vat_id` VARCHAR(32) NOT NULL,
          `business_id` VARCHAR(32) NOT NULL,
          `bank_name` VARCHAR(32) NOT NULL,
          `bank_account_name` VARCHAR(32) NOT NULL,
          `bank_account_iban` VARCHAR(32) NOT NULL,
          `op_stores_contacts_id` INT(11) DEFAULT NULL,
          `created_at` DATETIME NOT NULL,
          `updated_at` DATETIME NOT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(op_partners_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_partners_stores` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_services')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_services` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `op_stores_id` INT(11) NOT NULL,
          `duration` TIME NOT NULL,
          `price` DECIMAL(6,2) DEFAULT 0.00,
          `created_at` DATETIME NOT NULL,
          `updated_at` DATETIME NOT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          PRIMARY KEY (id, op_stores_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_services` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_contacts')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_contacts` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `op_stores_id` INT(11) NOT NULL,
          `private` TINYINT(1) NOT NULL DEFAULT 1,
          `name` VARCHAR(64) NOT NULL,
          `phone` VARCHAR(32) NOT NULL,
          `email` VARCHAR(96) NOT NULL,
          `created_at` DATETIME NOT NULL,
          `updated_at` DATETIME NOT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(op_stores_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_contacts` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_hours')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_hours` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `op_stores_id` INT(11) NOT NULL,
          `weekday` TINYINT(1) NOT NULL DEFAULT 0,
          `starts_at` TIME NOT NULL,
          `ends_at` TIME NOT NULL,
          `date_from` DATE DEFAULT NULL,
          `date_to` DATE DEFAULT NULL,
          `created_at` DATETIME NOT NULL,
          `updated_at` DATETIME NOT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(op_stores_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_hours` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_bookings')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_bookings` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `op_stores_id` INT(11) NOT NULL,
          `op_services_id` INT(11) NOT NULL,
          `customers_id` INT(11) NOT NULL,
          `remark` TEXT,
          `starts_at` DATETIME NOT NULL,
          `attended_at` DATETIME DEFAULT NULL,
          `cancelled_at` DATETIME DEFAULT NULL,
          `created_at` DATETIME NOT NULL,
          `updated_at` DATETIME NOT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(op_stores_id, customers_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_bookings` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_descriptions')) {
            $this->brand->query(
              '
        CREATE TABLE `op_descriptions` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `entity_id` INT(11) NOT NULL,
          `entity_type` VARCHAR(64) DEFAULT NULL,
          `language_id` INT(11) NOT NULL,
          `section` VARCHAR(64) DEFAULT NULL,
          `content` TEXT,
          `created_at` DATETIME NOT NULL,
          `updated_at` DATETIME NOT NULL,
          `deleted_at` DATETIME DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_descriptions` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_customers')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_customers` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `op_stores_id` INT(11) NOT NULL,
          `customers_id` INT(11) NOT NULL,
          `starts_at` DATETIME NOT NULL,
          `ends_at` DATETIME DEFAULT NULL,
          `created_at` DATETIME DEFAULT NULL,
          `updated_at` DATETIME DEFAULT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(op_stores_id, customers_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_customers` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_customers_measurements')) {
            $this->brand->query(
              '
        CREATE TABLE `op_customers_measurements` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `op_stores_id` INT(11) NOT NULL,
          `op_services_id` INT(11) NOT NULL,
          `customers_id` INT(11) NOT NULL,
          `consultant_name` VARCHAR(255),
          `values` TEXT,
          `remark` VARCHAR(255),
          `created_at` DATETIME DEFAULT NULL,
          `updated_at` DATETIME DEFAULT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(customers_id, op_stores_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_customers_measurements` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_commissions')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_commissions` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `orders_id` INT(11) NOT NULL,
          `on_behalf` TINYINT(1) NOT NULL,
          `op_stores_id` INT(11) NOT NULL,
          `orders_products_id` INT(11) DEFAULT NULL,
          `group` INT(11) DEFAULT NULL,
          `rate` DECIMAL(6,2) DEFAULT 0.00,
          `amount` DECIMAL(15,4) DEFAULT 0.0000,
          `product_type_id` INT(11) DEFAULT NULL,
          `created_at` DATETIME DEFAULT NULL,
          `updated_at` DATETIME DEFAULT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(orders_id, op_stores_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_commissions` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_orders')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_orders` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `orders_id` INT(11) NOT NULL,
          `customers_id` INT(11) NOT NULL,
          `op_stores_id` INT(11) NOT NULL,
          `on_behalf` TINYINT(1) DEFAULT NULL,
          `status` VARCHAR(64) DEFAULT "OP_ORDER_STATUS_OPEN",
          `order_total` DECIMAL(6,4) DEFAULT 0,
          `commission_calc` DECIMAL(6,4) DEFAULT 0,
          `commission_diff` DECIMAL(6,4) DEFAULT 0,
          `invoice_number` INT(11) DEFAULT NULL,
          `issued_at` DATETIME DEFAULT NULL,
          `paid_at` DATETIME DEFAULT NULL,
          `created_at` DATETIME DEFAULT NULL,
          `updated_at` DATETIME DEFAULT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(orders_id, op_stores_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_orders` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_stores_packages')) {
            $this->brand->query(
              '
        CREATE TABLE `op_stores_packages` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `status` VARCHAR(64) NOT NULL,
          `op_stores_orders_id` INT(11) NOT NULL,
          `orders_id` INT(11) NOT NULL,
          `package_id` INT(11) NOT NULL,
          `aftership_id` VARCHAR(32) DEFAULT NULL,
          `reminders` TINYINT(4) DEFAULT 0,
          `created_at` DATETIME DEFAULT NULL,
          `updated_at` DATETIME DEFAULT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(orders_id, op_stores_orders_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_stores_packages` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistTable('op_history')) {
            $this->brand->query(
              '
        CREATE TABLE `op_history` (
          `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `entity_id` INT(11) NOT NULL,
          `entity_type` VARCHAR(32) NOT NULL,
          `field` VARCHAR(32) NOT NULL,
          `value` VARCHAR(255) NOT NULL,
          `created_at` DATETIME DEFAULT NULL,
          `updated_at` DATETIME DEFAULT NULL,
          `deleted_at` DATETIME DEFAULT NULL,
          INDEX(entity_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            );
            $content .= "The `op_history` table has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('customers', 'op_stores_id')) {
            $this->brand->query('ALTER TABLE `customers` ADD COLUMN `op_stores_id` INT DEFAULT NULL');
            $content .= "The `customers.op_stores_id` column has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('op_partners', 'status')) {
            $this->brand->query('ALTER TABLE `op_partners` ADD COLUMN `status` TINYINT(1) NOT NULL DEFAULT 1 AFTER `name`');
            $content .= "The `op_partners.status` column has been successfully created.".PHP_EOL;
        }

        if ($this->checkExistColumnTable('op_partners', 'commission')) {
            $this->brand->query('ALTER TABLE `op_partners` DROP COLUMN `commission`');
            $content .= "The `op_partners.commission` column has been successfully deleted.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('op_partners', 'commission_1')) {
            $this->brand->query('ALTER TABLE `op_partners` ADD COLUMN `commission_1` TINYINT(2) NOT NULL DEFAULT 0 AFTER `status`');
            $content .= "The `op_partners.commission_1` column has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('op_partners', 'commission_2')) {
            $this->brand->query('ALTER TABLE `op_partners` ADD COLUMN `commission_2` TINYINT(2) NOT NULL DEFAULT 0 AFTER `commission_1`');
            $content .= "The `op_partners.commission_2` column has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('op_partners', 'commission_3')) {
            $this->brand->query('ALTER TABLE `op_partners` ADD COLUMN `commission_3` TINYINT(2) NOT NULL DEFAULT 0 AFTER `commission_2`');
            $content .= "The `op_partners.commission_3` column has been successfully created.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('op_partners', 'commission_4')) {
            $this->brand->query('ALTER TABLE `op_partners` ADD COLUMN `commission_4` TINYINT(2) NOT NULL DEFAULT 0 AFTER `commission_3`');
            $content .= "The `op_partners.commission_4` column has been successfully created.".PHP_EOL;
        }

        if ($this->checkExistColumnTable('op_stores_commissions', 'orders_id')) {
            $this->brand->query('ALTER TABLE `op_stores_commissions` DROP COLUMN `orders_id`');
            $content .= "The `op_stores_commissions.orders_id` column has been successfully deleted.".PHP_EOL;
        }

        if ($this->checkExistColumnTable('op_stores_commissions', 'on_behalf')) {
            $this->brand->query('ALTER TABLE `op_stores_commissions` DROP COLUMN `on_behalf`');
            $content .= "The `op_stores_commissions.on_behalf` column has been successfully deleted.".PHP_EOL;
        }

        if ($this->checkExistColumnTable('op_stores_commissions', 'op_stores_id')) {
            $this->brand->query('ALTER TABLE `op_stores_commissions` DROP COLUMN `op_stores_id`');
            $content .= "The `op_stores_commissions.op_stores_id` column has been successfully deleted.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('op_stores_commissions', 'op_stores_orders_id')) {
            $this->brand->query('ALTER TABLE `op_stores_commissions` ADD COLUMN `op_stores_orders_id` INT(11) NOT NULL DEFAULT 0 AFTER `id`');
            $content .= "The `op_stores_commissions.op_stores_orders_id` column has been successfully created.".PHP_EOL;
        }

        if ($this->checkExistColumnTable('op_stores_packages', 'delivered_at')) {
            $this->brand->query('ALTER TABLE `op_stores_packages` DROP COLUMN `delivered_at`');
            $content .= "The `op_stores_packages.delivered_at` column has been successfully created.".PHP_EOL;
        }

        if ($this->checkExistColumnTable('op_stores_orders', 'op_orders_status')) {
            $this->brand->query('ALTER TABLE `op_stores_orders` CHANGE COLUMN `op_orders_status` `status` VARCHAR(64) DEFAULT "OP_ORDER_STATUS_OPEN"');
            $content .= "The `op_stores_orders.op_orders_status` column has been successfully changed to `status`.".PHP_EOL;
        }

        if (!$this->checkExistColumnTable('op_stores_orders', 'customers_id')) {
            $this->brand->query('ALTER TABLE `op_stores_orders` ADD COLUMN `customers_id` INT(11) NOT NULL AFTER `orders_id`');

            $sql = '
              UPDATE `op_stores_orders` so 
              JOIN `orders` o 
                USING(orders_id) 
              SET `so`.`customers_id` = `o`.`customers_id`';
            $this->brand->query($sql);
            $content .= "The `op_stores_orders.customers_id` column has been successfully created and filled.".PHP_EOL;
        }

        // Change decimal length
        if ($this->checkExistTable('op_stores_orders') && $this->checkExistColumnTable('op_stores_orders', 'order_total')) {
            $sql = 'SELECT NUMERIC_PRECISION FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "' . $this->brand->data['db_name'] . '" AND TABLE_NAME = "op_stores_orders" AND COLUMN_NAME = "order_total"';
            if (db_get_single_value($sql) == '6') {
                $this->brand->query('ALTER TABLE `op_stores_orders` CHANGE COLUMN `order_total` `order_total` DECIMAL(15,4) DEFAULT 0');
                $this->brand->query('ALTER TABLE `op_stores_orders` CHANGE COLUMN `commission_calc` `commission_calc` DECIMAL(15,4) DEFAULT 0');
                $this->brand->query('ALTER TABLE `op_stores_orders` CHANGE COLUMN `commission_diff` `commission_diff` DECIMAL(15,4) DEFAULT 0');
                $content .= "The `".$this->sSiteId."`.``op_stores_orders` columns `order_total`, `commission_calc`, `commission_diff` has been changed.".PHP_EOL;
            }
        }

        // Change op_stores_orders.invoice_number column type
        if ($this->checkExistTable('op_stores_orders') && $this->checkExistColumnTable('op_stores_orders', 'invoice_number')) {
            $sql = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "' . $this->brand->data['db_name'] . '" AND TABLE_NAME = "op_stores_orders" AND COLUMN_NAME = "invoice_number"';
            if (db_get_single_value($sql) == 'int') {
                $this->brand->query('ALTER TABLE `op_stores_orders` CHANGE COLUMN `invoice_number` `invoice_number` VARCHAR(64) DEFAULT NULL');
                $content .= "The `".$this->sSiteId."`.``op_stores_orders` column `invoice_number` has been changed.".PHP_EOL;
            }
        }

        foreach (self::$tables as $k => $v) {
          if ($this->checkExistTable($v) && $this->checkExistColumnTable($v, 'updated_at')) {
            $sql = 'SELECT IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "' . $this->brand->data['db_name'] . '" AND TABLE_NAME = "' . $v . '" AND COLUMN_NAME = "updated_at"';
            if (db_get_single_value($sql) == 'NO') {
              $this->brand->query('ALTER TABLE `' . $v . '` CHANGE COLUMN `updated_at` `updated_at` DATETIME DEFAULT NULL');
            }
          }
          // Remove indexes on 'id'
          if (db_get_single_value('SHOW INDEX FROM `'.$this->brand->data['db_name'] .'`.`'.$v.'` WHERE KEY_NAME = "id"')) {
              $this->brand->query('DROP INDEX id ON '.$v);
          }
        }
        // END DB migrations

        // Admin script optical_partners.php
        $content .= Security::add_brand_page_to_box('optical_partners.php', 'OP_OPTICAL_PARTNERS', 'customers', 1);

        // Admin script optical_partners_reports.php
        $content .= Security::add_brand_page_to_box('optical_partners_reports.php', 'OP_OPTICAL_PARTNERS', 'customers', 1);

        // 'Optical partners' configurations
        if ($configGroupId = $this->getConfigGroup(
          'Optical partners',
          'Optical partners configuration.',
          1,
          $content
        )) {

            if (!$this->getConfiguration('OP_BOOKING_PAST_PERIOD')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Edit booking past period',
                    'configuration_key' => 'OP_BOOKING_PAST_PERIOD',
                    'configuration_value' => '7',
                    'configuration_description' => 'Period, during which store manager can edit booking. (days)',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 10,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_FITTING_REMINDER')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Fitting reminder (days)',
                    'configuration_key' => 'OP_FITTING_REMINDER',
                    'configuration_value' => '21',
                    'configuration_description' => 'Fitting reminder (days).',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 20,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_PICKUP_REMINDER_1')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Pickup reminder 1 (days)',
                    'configuration_key' => 'OP_PICKUP_REMINDER_1',
                    'configuration_value' => '7',
                    'configuration_description' => 'Pickup reminder 1 (days).',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 22,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_PICKUP_REMINDER_2')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Pickup reminder 2 (days)',
                    'configuration_key' => 'OP_PICKUP_REMINDER_2',
                    'configuration_value' => '3',
                    'configuration_description' => 'Pickup reminder 2 (days).',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 24,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_TAKE_OVER_PERIOD')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Take over period (days)',
                    'configuration_key' => 'OP_TAKE_OVER_PERIOD',
                    'configuration_value' => '30',
                    'configuration_description' => 'Period, during which new Store (after Taking over) needs to create a meassurement for this customer. (days)',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 30,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_NOTIFICATIONS_NAME_FROM')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Notifications / Name (from)',
                    'configuration_key' => 'OP_NOTIFICATIONS_NAME_FROM',
                    'configuration_value' => 'MrLens',
                    'configuration_description' => 'Notifications / Name (from)',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 40,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_NOTIFICATIONS_BOOKING_EMAIL_FROM')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Appointment notifications / E-mail (from)',
                    'configuration_key' => 'OP_NOTIFICATIONS_BOOKING_EMAIL_FROM',
                    'configuration_value' => 'termin@mrlens.ch',
                    'configuration_description' => 'Appointment notifications / E-mail (from)',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 45,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_NOTIFICATIONS_GENERAL_EMAIL_FROM')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'General notifications / E-mail (from)',
                    'configuration_key' => 'OP_NOTIFICATIONS_GENERAL_EMAIL_FROM',
                    'configuration_value' => 'info@mrlens.ch',
                    'configuration_description' => 'General notifications / E-mail (from)',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 50,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_COUPON_RULE_ID')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Coupon rule ID',
                    'configuration_key' => 'OP_COUPON_RULE_ID',
                    'configuration_value' => '0',
                    'configuration_description' => 'Coupon rule ID for excluded product brands.',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 60,
                  ]
                );
            }

            if (!$this->getConfiguration('OP_RECORDS_PER_PAGE')) {
                $content .= $this->setConfiguration(
                  [
                    'configuration_title' => 'Records per page',
                    'configuration_key' => 'OP_RECORDS_PER_PAGE',
                    'configuration_value' => '30',
                    'configuration_description' => 'Records / Entries per page.',
                    'set_function' => '',
                    'configuration_group_id' => $configGroupId,
                    'sort_order' => 70,
                  ]
                );
            }

          if ($this->getConfiguration('OP_EMAIL_FROM')) {
            $this->deleteConfiguration('OP_EMAIL_FROM');
          }

          if ($this->getConfiguration('OP_EMAIL_NAME')) {
            $this->deleteConfiguration('OP_EMAIL_NAME');
          }

        }
        // END 'Optical partners' configurations

        // Cron job
        if (!$this->checkExistCron('optical_partners.php')) {
            $this->brand->insert(
              "cron_jobs",
              [
                'week_day' => "*",
                'month' => "*",
                'day' => "*",
                'hour' => "23",
                'minute' => "30",
                'job_name' => "Optical partners",
                'command' => "optical_partners.php",
                'status' => 0,
              ]
            );
            $content .= "Cron job for optical partners added successfully.".PHP_EOL;
        }

        return $content;
    }
}