<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">

    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
        {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>

    <div class="col col--lg-8 col--lmd-8 col--md-12 col--sm-12">

      <h2>{'OP_APPOINTMENT_HEADING'|tr}</h2>

      <form name="updateBooking" id="updateBooking" method="post">

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="entity" value="booking" />
        <input type="hidden" name="section" value="detail" />
        <input type="hidden" name="booking" value="{$booking.id}" />

        <div class="form-flow-inline">

          {if $booking.cancelled_at}
          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_APPOINTMENT_CANCELLED'|tr}</strong></label>
            {$booking.cancelled_at|date_format:'%d.%m.%Y %H:%M'}
          </div>
          {/if}

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_APPOINTMENT_CUSTOMER'|tr}</strong></label>
            <a href="{'op_admin_customers.php'|tep_href_link:'section=detail&entity=customer&customer='}{$booking.customers_id}">{$customer.name}</a>
            </label>
          </div>

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_APPOINTMENT_SERVICE'|tr}</strong></label>
            {$booking.name}
          </div>

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_APPOINTMENT_DATE'|tr}</strong></label>
            {$booking.starts_at|date_format:'%d.%m.%Y %H:%M'}
          </div>

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_APPOINTMENT_DURATION'|tr}</strong></label>
            {$booking.duration|date_format:'%H:%M'} {'OP_APPOINTMENT_DURATION_IN_MINUTES'|tr}
          </div>

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_APPOINTMENT_REMARK'|tr}</strong></label>
            <textarea name="remark" rows="5"{if $booking.cancelled_at || !$booking.upcoming} disabled="disabled"{/if}>{$booking.remark}</textarea>
          </div>

          {if !$booking.cancelled_at}
            {if $booking.upcoming}
              <div class="form-row form-row-replica">
                <label class="form-row-label"><strong>{'OP_APPOINTMENT_ACTIONS'|tr}</strong></label>

                <a href="{'op_admin_customers.php'|tep_href_link}?section=bookingCreate&entity=customer&customer=428475&booking={$booking.id}" class="button button-secondary">{'OP_APPOINTMENT_RESCHEDULE'|tr}</a>&nbsp;

                <a href="{'op_admin_bookings.php'|tep_href_link}?section={$smarty.get.section}&booking={$booking.id}&action=cancel" class="button button-secondary cancelButton">{'OP_APPOINTMENT_CANCEL'|tr}</a>&nbsp;&nbsp;

                <input type="submit" value="{'OP_APPOINTMENT_UPDATE'|tr}" class="button button-primary" />

              </div>
            {else}
              {if $booking.editable}

              <div class="form-row form-row-replica">
                <label class="form-row-label"><strong>{'OP_APPOINTMENT_CUSTOMER_ATTENDANCE'|tr}</strong></label>
                <input type="checkbox" name="attended_at"{if $booking.attended_at} checked="checked" disabled="disabled"{/if} style="width: auto" />&nbsp;
                {if $booking.attended_at}
                  <em>{'OP_APPOINTMENT_CUSTOMER_ATTENDANCE_ON'|tr} {$booking.attended_at|date_format:'%d.%m.%Y %H:%M'}</em>
                {/if}
              </div>

              {if !$booking.attended_at}
              <div class="form-row form-row-replica">
                <label class="form-row-label">&nbsp;</label>
                <label class="form-row-label">&nbsp;</label>
                <input type="submit" value="{'OP_APPOINTMENT_UPDATE'|tr}" class="button button-primary" />
              </div>
              {/if}

              {/if}
            {/if}
          {/if}

        </form>

      </div>
    </div>
  </div>
</div>

<!-- CANCEL PROMPT -->
<div id="cancelContent" style="display: none;">{'OP_APPOINTMENT_CANCEL_PROMPT'|tr}</div>
<div id="cancelFooter" style="display: none;">
  <button class="button button-tertiary" hide_on_click="true">{'OP_APPOINTMENT_CANCEL'|tr}</button>
  <a id="cancelLink" href="#" class="button button-primary float-right">{'OP_APPOINTMENT_CONFIRM'|tr}</a>
</div>

<script>
  var OPTICAL_PARTNERS_ADMIN = true;

  // CANCEL PROMPT
  $('body').on('click', '.cancelButton', function(e) {
    e.preventDefault();
    document.getElementById('cancelLink').href = $(this).attr('href');
    $Vmodal.makeFull(
      "{'OP_APPOINTMENT_CANCEL'|tr}",
      document.getElementById('cancelContent').innerHTML,
      document.getElementById('cancelFooter').innerHTML,
      false);
  });

  // DELETE PROMPT
  $('body').on('click', '.deleteButton', function(e) {
    e.preventDefault();
    document.getElementById('deleteLink').href = $(this).attr('href');
    $Vmodal.makeFull(
      "{'OP_APPOINTMENT_DELETE'|tr}",
      document.getElementById('deleteContent').innerHTML,
      document.getElementById('deleteFooter').innerHTML,
      false);
  });

</script>