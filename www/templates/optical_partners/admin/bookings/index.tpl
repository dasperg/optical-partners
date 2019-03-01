<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
      {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>
    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <div class="op-content-with-menu">
        <h2>{$pageTitle|tr}</h2>
        {if count($bookings) > 0}
          <table class="table optical-table responsive-table">
            <thead>
              <tr>
                <th>{'OP_APPOINTMENT_CUSTOMER'|tr}</th>
                <th>{'OP_APPOINTMENT_SERVICE'|tr}</th>
                <th>{'OP_APPOINTMENT_DATE'|tr}</th>
                <th>{'OP_APPOINTMENT_DURATION'|tr}</th>
                <th>{'OP_APPOINTMENT_REMARK'|tr}</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$bookings item=booking key=bookingId}
                <tr {if $booking.cancelled_at}style="background-color: #ffe5e5"{/if}>
                  <td>
                    <a href="{'op_admin_customers.php'|tep_href_link:'section=detail&entity=customer&customer='}{$booking.customers_id}">{$booking.customer.name}</a>
                  </td>
                  <td>{$booking.name}</td>
                  <td>{$booking.starts_at|date_format:'%d.%m.%Y %H:%M'}</td>
                  <td>{$booking.duration|date_format:'%H:%M'}</td>
                  <td>
                    {if !$booking.cancelled_at}
                      {$booking.remark|truncate:20}
                    {else}
                      <em>{'OP_APPOINTMENT_CANCELLED'|tr}</em>
                    {/if}
                  </td>
                  <td>
                    {if (!$booking.cancelled_at && $booking.editable)}
                    <a href="{'op_admin_bookings.php'|tep_href_link}?booking={$bookingId}&action=edit&section=detail" class="button button-primary">{'OP_APPOINTMENT_EDIT'|tr}</a>
                    {/if}
                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        {else}
          <div class="message_stack-warning">{'OP_APPOINTMENT_NO_BOOKINGS'|tr}</div>
        {/if}
      </div>
    </div>
  </div>
</div>

<style>
  @media screen and (max-width: 600px) {
    td:nth-of-type(1):before {
      content: "{'OP_APPOINTMENT_CUSTOMER'|tr}:";
    }

    td:nth-of-type(2):before {
      content: "{'OP_APPOINTMENT_SERVICE'|tr}:";
    }

    td:nth-of-type(3):before {
      content: "{'OP_APPOINTMENT_DATE'|tr}:";
    }

    td:nth-of-type(4):before {
      content: "{'OP_APPOINTMENT_REMARK'|tr}:";
    }

    td:nth-of-type(5):before {
      content: "{'OP_APPOINTMENT_DURATION'|tr}:";
    }
  }
</style>