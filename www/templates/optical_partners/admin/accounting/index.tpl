<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--sm-12">
      <h2>{$pageTitle|tr}</h2>

      {if count($periods) > 0}
        <table class="table optical-table">
          <thead>
          <tr>
            <th>{'OP_ACCOUNTING_PERIOD'|tr}</th>
            <th class="th text-right">{'OP_ACCOUNTING_ORDERS'|tr}</th>
            <th class="th text-right">{'OP_ACCOUNTING_TOTAL'|tr}</th>
            <th class="th text-right">{'OP_ACCOUNTING_COMMISSION'|tr}</th>
          </tr>
          </thead>
          <tbody>
          {foreach from=$periods item=period}
            <tr>
              <td class="td"><a href="op_admin_accounting.php?action=detail&period={$period.date}">{$period.date}</a></td>
              <td class="td text-right">{$period.orders_count}</td>
              <td class="td text-right">{'OP_CURRENCY_CHF'|tr} {$period.total|string_format:"%.2f"}</td>
              <td class="td text-right">{'OP_CURRENCY_CHF'|tr} {$period.commission|string_format:"%.2f"}</td>
            </tr>
          {/foreach}
          </tbody>
        </table>
      {elseif count($orders) > 0}
      {else}
        <div class="message_stack-warning">{'OP_ACCOUNTING_NO_ORDERS'|tr}</div>
      {/if}

    </div>
  </div>
</div>
<style>
  @media screen and (max-width: 600px) {
    td:nth-of-type(1):before { content:"{'OP_ORDER_NUMBER'|tr}:";}
    td:nth-of-type(2):before { content:"{'OP_ORDER_CUSTOMER'|tr}:";}
    td:nth-of-type(3):before { content:"{'OP_ORDER_STATUS'|tr}:";}
    td:nth-of-type(4):before { content:"{'OP_ORDER_DATE'|tr}:";}
    td:nth-of-type(5):before { content:"{'OP_ORDER_TOTAL'|tr}:";}
    td:nth-of-type(6):before { content:"{'OP_ORDER_COMMISSION'|tr}:";}
  }
</style>