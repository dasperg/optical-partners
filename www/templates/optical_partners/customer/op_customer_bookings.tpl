<div class="account-details-wrapper account-lobby-wrapper">
  <div class="inner-wrapper">
    <div class="row">

      <div class="col col--lg-3 col--md-12 col--sm-12">
        {include file='includes/account_tabs.tpl'}
      </div>

      <div class="col col--lg-9 col--md-12 col--sm-12">

        <div class="account-pages-white-col">
          <h3>{'OP_MY_BOOKINGS'|tr}</h3>
          {if count($bookings) > 0}
          <div class="account-pages-white-in m-b-lg">
            <table class="table optical-table responsive-table">
              <thead>
                <tr>
                  <th>{'OP_APPOINTMENT_STORE'|tr}</th>
                  <th>{'OP_APPOINTMENT_SERVICE'|tr}</th>
                  <th>{'OP_APPOINTMENT_DATE'|tr}</th>
                  <th>{'OP_APPOINTMENT_DURATION'|tr}</th>
                  <th colspan="2">{'OP_APPOINTMENT_ACTIONS_AND_REMARK'|tr}</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$bookings item=booking key=bookingId}
                  <tr {if $booking.cancelled_at}style="background-color: #ffe5e5"{/if}>
                    <td>
                      <a href="{'optical_partner_detail.php'|tep_href_link}?partner={$booking.partner}&store={$booking.op_stores_id}" target="_blank">{$booking.store}</a>
                    </td>
                    <td>{$booking.name}</td>
                    <td>{$booking.starts_at|date_format:'%d.%m.%Y %H:%M'}</td>
                    <td>{$booking.duration|date_format:'%H:%M'}</td>
                    {if !$booking.cancelled_at && $booking.cancellable}
                    <td>
                      <a href="{'op_customer_bookings.php'|tep_href_link}?id={$bookingId}&action=cancel&entity=booking" class="button button-secondary cancelButton"><small>{'OP_APPOINTMENT_CANCEL'|tr}</small></a>
                    </td>
                    <td>
                      <a href="{'optical_partner_detail.php'|tep_href_link}?partner={$booking.partner}&store={$booking.op_stores_id}&entity=customer&customer={$smarty.session.customer_id}&booking={$bookingId}&service={$booking.op_services_id}#/booking" class="button button-secondary"><small>{'OP_APPOINTMENT_RESCHEDULE'|tr}</small></a>
                    </td>
                    {else}
                      <td colspan="2">
                        <em>
                          {if !$booking.cancelled_at}
                            {$booking.remark|truncate:20}
                          {else}
                            {'OP_APPOINTMENT_CANCELLED'|tr}
                          {/if}
                        </em>
                      </td>
                    {/if}
                  </tr>
                {/foreach}
              </tbody>
            </table>
          </div>
          {else}
            <div class="message_stack-warning">{'OP_APPOINTMENT_NO_BOOKINGS'|tr}</div>
          {/if}

          <h3>{'OP_MY_MEASUREMENTS'|tr}</h3>
          {if count($measurements) > 0}
          <div class="account-pages-white-in m-b-lg">
            
            <table class="table responsive-table">
              <tbody>
                {foreach from=$measurements item=measurement name=cm}
                <tr>
                  <td>{'OP_MEASUREMENT_DATE'|tr}:</td>
                  <td>{$measurement.created_at|date_format:'%d.%m.%Y %H:%M'}</td>
                  <td rowspan="3">
                    <table class="partner-measurement-table">
                      <thead>
                        <tr>
                          <th class="cell-white"></th>
                          {assign var=first value=$measurement.data|@key}
                          {foreach from=$measurement.data->$first key=type item=item}
                            <th>{'OP_CUSTOMER_MEASUREMENT_ATTR_'|cat:$type|tr}</th>
                          {/foreach}
                        </tr>
                      </thead>
                      <tbody>
                      {foreach from=$measurement.data key=eye item=data}
                        <tr>
                          <td class="th text-left">{'OP_CUSTOMER_MEASUREMENT_'|cat:$eye|tr}</td>
                          {foreach from=$data item=eyeMeasurements}
                            <td>{$eyeMeasurements}</td>
                          {/foreach}
                        </tr>
                      {/foreach}
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>{'OP_MEASUREMENT_SERVICE'|tr}:</td>
                  <td>{$measurement.service.content}</td>
                </tr>
                <tr>
                  <td>{'OP_MEASUREMENT_CONSULTANT'|tr}:</td>
                  <td>{$measurement.consultant_name}</td>
                </tr>
                {if $measurement.remark != ''}
                <tr>
                  <td colspan="3"><br/><em><small>{$measurement.remark}</small></em></td>
                </tr>
                {/if}
                {if not $smarty.foreach.cm.last}
                <tr>
                  <td colspan="3" class="m-b-lg m-t-lg"><hr /><br /></td>
                </tr>
                {/if}
              {/foreach}
              </tbody>
            </table>
          </div>
          {else}
            <div class="message_stack-warning">{'OP_APPOINTMENT_NO_MEASUREMENTS'|tr}</div>
          {/if}
        </div>
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

<script type="text/javascript">

  $('.account-pages-white-col').css('min-height', $('.account-nav').height());

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

</script>