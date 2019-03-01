<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
      {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>

    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <h2>{$pageTitle|tr}</h2>
      <div class="form-flow-inline">
        <div class="form-row form-row-replica">
          <label class="form-row-label"><strong>{'OP_CUSTOMER_MEASUREMENT_DATE'|tr}</strong></label>
          <span>{$measurement.created_at|date_format:"%d.%m.%Y"}</span>
        </div>
        <div class="form-row form-row-replica">
          <label class="form-row-label"><strong>{'OP_CUSTOMER_MEASUREMENT_CONSULTANT'|tr}</strong></label>
          <span>{$measurement.consultant_name}</span>
        </div>
        <div class="form-row form-row-replica">
          <label class="form-row-label"><strong>{'OP_CUSTOMER_MEASUREMENT_SERVICE'|tr}</strong></label>
          <span>{$measurement.service.content}</span>
        </div>
        {if $measurement.remark != ''}
          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_CUSTOMER_MEASUREMENT_REMARK'|tr}</strong></label>
            <span>{$measurement.remark}</span>
          </div>
        {/if}
        <div class="form-row form-row-replica">
          <label class="form-row-label"><strong>{'OP_CUSTOMER_MEASUREMENT_CORRECTION'|tr}</strong></label>
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
        </div>
      </div>

      {* <div class="partner-measurement-table-wrapper">
        <div>
          <span><small><strong>{'OP_CUSTOMER_MEASUREMENT_CORRECTION'|tr}</strong></small></span>
          <table class="partner-measurement-table">
            <thead>
              <tr>
                <th class="cell-white"></th>
                {assign var=first value = $measurement.data|@key}
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
        </div> *}
      </div>
    </div>
  </div>
</div>