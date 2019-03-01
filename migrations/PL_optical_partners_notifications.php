<?php

class InstallBrand_PL_optical_partners_notifications extends moduleInstallBrands
{

    /*
      OP_BOOKING_CREATE
      OP_BOOKING_RESCHEDULE
      OP_BOOKING_CANCEL
      OP_BOOKING_REMIND
      OP_SERVICE_REMIND
      OP_ORDER_ARRIVAL
      OP_ORDER_REMIND
    */

    var $dependBrandModules = ['bulk_customers', 'PL_optical_partners'];

    public static function getDescription()
    {
        return 'Install script for Optical Partners / Notifications.';
    }

    public function dbInstall()
    {

        $content = '';

        $emails = [

          'OP_BOOKING_CREATE' => [
            'en' => [
              'subject' => 'Your appointment was successfully created',
              'body' => '
                <p><strong>Your appointment was successfully created.</strong><br><br><strong>General information</strong><br> Appointment ID: {$booking.id}<br> Date and time: {$booking.starts_at|date_format:"%d.%m.%Y"} at {$booking.starts_at|date_format:"%H:%M"}<br> Optical service: {$booking.name}<br>Duration: {$booking.duration|date_format:"%H:%M"}<br>Remark: <em>{$booking.remark}</em><br><br><strong>Optical store</strong><br>Store name: {$booking.store.name}<br>Address: {$booking.store.street}, {$booking.store.zip} {$booking.store.city}<br>Contact: {$booking.contact.name}, {$booking.contact.phone}, {$booking.contact.email}<br><br> <strong>Customer</strong><br>Name: {$booking.customer.salutation} {$booking.customer.customers_firstname} {$booking.customer.customers_lastname}<br> Email: {$booking.customer.customers_email_address}<br> Phone: {$booking.customer.customers_telephone}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

          'OP_BOOKING_RESCHEDULE' => [
            'en' => [
              'subject' => 'Your appointment was successfully rescheduled',
              'body' => '
                <p><strong>Your appointment was successfully rescheduled.</strong><br><br><strong>General information</strong><br> Appointment ID: {$booking.id}<br> Date and time: {$booking.starts_at|date_format:"%d.%m.%Y"} at {$booking.starts_at|date_format:"%H:%M"}<br> Optical service: {$booking.name}<br>Duration: {$booking.duration|date_format:"%H:%M"}<br>Remark: <em>{$booking.remark}</em><br><br><strong>Optical store</strong><br>Store name: {$booking.store.name}<br>Address: {$booking.store.street}, {$booking.store.zip} {$booking.store.city}<br>Contact: {$booking.contact.name}, {$booking.contact.phone}, {$booking.contact.email}<br><br> <strong>Customer</strong><br>Name: {$booking.customer.salutation} {$booking.customer.customers_firstname} {$booking.customer.customers_lastname}<br> Email: {$booking.customer.customers_email_address}<br> Phone: {$booking.customer.customers_telephone}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

          'OP_BOOKING_CANCEL' => [
            'en' => [
              'subject' => 'Your appointment was successfully cancelled',
              'body' => '
                <p><strong>Your appointment was successfully cancelled.</strong><br><br><strong>General information</strong><br> Appointment ID: {$booking.id}<br> Date and time: {$booking.starts_at|date_format:"%d.%m.%Y"} at {$booking.starts_at|date_format:"%H:%M"}<br> Optical service: {$booking.name}<br>Duration: {$booking.duration|date_format:"%H:%M"}<br>Remark: <em>{$booking.remark}</em><br><br><strong>Optical store</strong><br>Store name: {$booking.store.name}<br>Address: {$booking.store.street}, {$booking.store.zip} {$booking.store.city}<br>Contact: {$booking.contact.name}, {$booking.contact.phone}, {$booking.contact.email}<br><br> <strong>Customer</strong><br>Name: {$booking.customer.salutation} {$booking.customer.customers_firstname} {$booking.customer.customers_lastname}<br> Email: {$booking.customer.customers_email_address}<br> Phone: {$booking.customer.customers_telephone}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

          'OP_BOOKING_REMIND' => [
            'en' => [
              'subject' => 'Reminder for your upcoming appointment',
              'body' => '
                <p><strong>Reminder for your upcoming appointment.</strong><br><br><strong>General information</strong><br> Appointment ID: {$booking.id}<br> Date and time: {$booking.starts_at|date_format:"%d.%m.%Y"} at {$booking.starts_at|date_format:"%H:%M"}<br> Optical service: {$booking.name}<br>Duration: {$booking.duration|date_format:"%H:%M"}<br>Remark: <em>{$booking.remark}</em><br><br><strong>Optical store</strong><br>Store name: {$booking.store.name}<br>Address: {$booking.store.street}, {$booking.store.zip} {$booking.store.city}<br>Contact: {$booking.contact.name}, {$booking.contact.phone}, {$booking.contact.email}<br><br> <strong>Customer</strong><br>Name: {$booking.customer.salutation} {$booking.customer.customers_firstname} {$booking.customer.customers_lastname}<br> Email: {$booking.customer.customers_email_address}<br> Phone: {$booking.customer.customers_telephone}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

          'OP_SERVICE_REMIND' => [
            'en' => [
              'subject' => 'Fitting reminder in relation to your previous optical service',
              'body' => '
                <p><strong>Fitting reminder in relation to your previous optical service</strong><br><br>Based on your previous appointment and measurement ({$service.service.content}) at {$service.store.name} on {$service.created_at|date_format:"%d.%m.%Y"} ({$smarty.const.OP_FITTING_REMINDER} days ago), we\'d like to suggest you to continue with Contact lens fitting.<br><br>Feel free to book the appointment by your optical store: {$service.store.link}<br><br><strong>Optical store</strong><br>Store name: {$service.store.name}<br>Address: {$service.store.street}, {$service.store.zip} {$service.store.city}<br>Contact: {$service.contact.name}, {$service.contact.phone}, {$service.contact.email}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

          'OP_PACKAGE_ARRIVAL' => [
            'en' => [
              'subject' => 'Your order is ready for pickup at Optical Store',
              'body' => '
                <p><strong>Your order is ready for pickup at Optical Store</strong><br><br>Order ID: {$package.orders_id}<br><br><strong>Optical store</strong><br>Store name: {$package.store.name}<br>Address: {$package.store.street}, {$package.store.zip} {$package.store.city}<br>Contact: {$package.contact.name}, {$package.contact.phone}, {$package.contact.email}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

          'OP_PACKAGE_REMIND_1' => [
            'en' => [
              'subject' => 'Reminder #1: Your order is ready for pickup at Optical Store',
              'body' => '
                <p><strong>Your order is ready for pickup at Optical Store</strong><br><br>Order ID: {$package.orders_id}<br><br><strong>Optical store</strong><br>Store name: {$package.store.name}<br>Address: {$package.store.street}, {$package.store.zip} {$package.store.city}<br>Contact: {$package.contact.name}, {$package.contact.phone}, {$package.contact.email}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

          'OP_PACKAGE_REMIND_2' => [
            'en' => [
              'subject' => 'Reminder #2: Your order is ready for pickup at Optical Store',
              'body' => '
                <p><strong>Your order is ready for pickup at Optical Store</strong><br><br>Order ID: {$package.orders_id}<br><br><strong>Optical store</strong><br>Store name: {$package.store.name}<br>Address: {$package.store.street}, {$package.store.zip} {$package.store.city}<br>Contact: {$package.contact.name}, {$package.contact.phone}, {$package.contact.email}</p>',
            ],
            'de' => [
              'subject' => 'de',
              'body' => 'de',
            ],
            'fr' => [
              'subject' => 'fr',
              'body' => 'fr',
            ],
          ],

        ];

        foreach ($emails as $internalName => $email) {

            if ($this->brand->db_get_single_value("SELECT COUNT(*) FROM `emails` WHERE internal_name = '" . $internalName . "'") < 1) {

                foreach (MultiLang::get_languages() as $code => $row) {
                    if (!isset($email[$code])) {
                        continue;
                    }
                    $this->brand->insert('emails', [
                      'subject' => $email[$code]['subject'],
                      'body' => $email[$code]['body'],
                      'internal_name' => $internalName,
                      'language_id' => $row['id'],
                      'as_html' => 1,
                      'has_footer' => 0,
                      'status' => 1,
                      'is_smarty' => 1,
                    ]);
                }

                $content .= "Created email: " . $internalName . PHP_EOL;

            }

        }

        return $content;

    }

}