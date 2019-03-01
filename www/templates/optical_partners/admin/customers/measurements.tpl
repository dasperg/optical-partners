<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
      {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>

    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <div class="op-content-with-menu">
        <h2>{$pageTitle|tr}</h2>
        {if count($measurements)>0}
          <table class="table optical-table">
            <thead>
              <tr class="tr">
                <th class="th">{'OP_CUSTOMER_MEASUREMENT_DATE'|tr}</th>
                <th class="th">{'OP_CUSTOMER_MEASUREMENT_CONSULTANT'|tr}</th>
                <th class="th">{'OP_CUSTOMER_MEASUREMENT_SERVICE'|tr}</th>
                <th class="th"></th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$measurements key=id item=measurement}
                <tr class="tr">
                  <td class="td">{$measurement.created_at|date_format:'%d.%m.%Y'}</td>
                  <td class="td">{$measurement.consultant_name}</td>
                  <td class="td">{$measurement.service.content}</td>
                  <td class="td right"><a href="{'op_admin_customers.php'|tep_href_link}?section=measurementDetail&entity=customer&customer={$measurement.customers_id}&measurement={$id}" class="button button-primary">{'OP_CUSTOMER_DETAIL'|tr}</a></td>
                </tr>
                {/foreach}
            </tbody>
          </table>
        {else}
          <div class="message_stack-warning">{'OP_CUSTOMER_NO_MEASUREMENTS'|tr}</div>
        {/if}

        <br /><br /><br /><br />

        <h2>{'OP_CUSTOMER_MEASUREMENT_CREATE'|tr}</h2>
        <form id="measurement-create" method="post" class="form measurement-create select-arrow-show">
          <input type="hidden" name="action" value="create" />
          <input type="hidden" name="op_stores_id" value="{$smarty.session.op_stores_id}" />
          <input type="hidden" name="id" value="{$smarty.get.customer}" />
          <input type="hidden" name="customers_id" value="{$smarty.get.customer}" />
          <div class="row">
            <div class="col--md-6">
              <div class="form-row custom-param">
                <label for="consultant_name" class="form-row-label"><strong>{'OP_CUSTOMER_MEASUREMENT_CONSULTANT'|tr}</strong></label>
                <div class="select-wrapper">
                  <select id="contacts">
                      <option></option>
                    {foreach from=$contacts item=contact}
                        <option>{$contact.name}</option>
                    {/foreach}
                  </select>
                </div>
                <input type="text" id="consultant_name" name="consultant_name" value="" placeholder="{'OP_CUSTOMER_MEASUREMENT_CONSULTANT_HINT'|tr}" />
              </div>
            </div>
            <div class="col--md-6">
              <div class="form-row custom-param services-param">
                <label for="service_id" class="form-row-label">
                  <strong>{'OP_CUSTOMER_MEASUREMENT_SERVICE'|tr} *</strong>
                </label>
                <div class="select-wrapper">
                  <select name="op_services_id">
                      <option value="">{'OP_BOOKING_SERVICE_PROMPT'|tr}</option>
                    {foreach from=$services key=id item=service}
                      <option value="{$id}">{$service.name}</option>
                    {/foreach}
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            {for $i=1 to 2}
              <div class="col--md-6">
                <p class="order-detail-headline">
                  {if $i == 1}
                    <label>{'OP_CUSTOMER_MEASUREMENT_LEFT'|tr}</label>
                  {else}
                    <label>{'OP_CUSTOMER_MEASUREMENT_RIGHT'|tr}</label>
                  {/if}
                </p>
                {foreach from=$measurementTypes item=name}
                  <div class="form-row eye-param">
                    <label><strong>{$name} {if in_array($name, ['SPH', 'CYL', 'AXS'])}*{/if}</strong></label>
                    <input type="text" name="measurements[{($i == 1) ? 'LEFT' : 'RIGHT'}][{$name}]" value="">
                  </div>
                {/foreach}
              </div>
            {/for}
          </div>
          <div class="row">
            <div class="col--md-12">
              <div class="form-row custom-param">
                <label for="remark" class="form-row-label"><strong>{'OP_CUSTOMER_MEASUREMENT_REMARK'|tr}</strong></label>
                <textarea name="remark" maxlength="255" id="remark"></textarea>
              </div>
            </div>
          </div>
          <input type="submit" class="button button-primary float-right" value="{'OP_CUSTOMER_MEASUREMENT_SUBMIT'|tr}">
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
  $('#contacts').on('change', function () {
     $('#consultant_name').val(this.value);
  });

  $('#measurement-create').validate({
    errorClass: "validation-error",
    rules: {
      'measurements[LEFT][SPH]': {
        required: true
      },
      'measurements[RIGHT][SPH]': {
        required: true
      },
      'measurements[LEFT][CYL]': {
        required: true
      },
      'measurements[RIGHT][CYL]': {
        required: true
      },
      'measurements[LEFT][AXS]': {
        required: true
      },
      'measurements[RIGHT][AXS]': {
        required: true
      },
      'op_services_id': {
        required: true
      }
    }
  });
});
</script>