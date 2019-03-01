<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
      {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>

    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <div class="op-content-with-menu">
        <h2>{$pageTitle|tr}</h2>
        {if count($orders) > 0}
          <table class="table optical-table responsive-table">
            <thead>
              <tr class="tr">
                <th class="th">{'OP_CUSTOMER_ORDER_NUMBER'|tr}</th>
                <th class="th">{'OP_CUSTOMER_ORDER_TOTAL'|tr}</th>
                <th class="th">{'OP_CUSTOMER_ORDER_DATE'|tr}</th>
                <th class="th">{'OP_CUSTOMER_ORDER_STATUS'|tr}</th>
                <th class="th"></th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$orders item=order key=orderId}
                <tr class="tr">
                  <td class="td">
                    <a href="{'op_admin_customers.php'|tep_href_link}?section=orderDetail&entity=customer&customer={$order.customers_id}&order={$orderId}">{$orderId}</a>
                  </td>
                  <td class="td">{'OP_CURRENCY_CHF'|tr} {$order.total_value|string_format:"%.2f"}</td>
                  <td class="td">{$order.date_purchased|date_format:'%d.%m.%Y'}</td>
                  <td class="td">{$order.status|tr}</td>
                  <td class="td right">
                    <a href="{'op_admin_customers.php'|tep_href_link}?section=orderDetail&entity=customer&customer={$customer.customers_id}&order={$orderId}" class="button button-primary">{'OP_CUSTOMER_DETAIL'|tr}</a>
                  </td>
                </tr>
              {/foreach}    
            </tbody>
          </table>
          <div class="m-t-sm text-right">{$paginationLinks}</div>
        {else}
          <div class="message_stack-warning">{'OP_CUSTOMER_NO_ORDERS'|tr}</div>
        {/if}
      </div>
    </div>
  </div>
</div>

<style>
@media screen and (max-width: 600px) {
  td:nth-of-type(1):before { content:"{'OP_CUSTOMER_ORDER_NUMBER'|tr}:";}
  td:nth-of-type(2):before { content:"{'OP_CUSTOMER_ORDER_TOTAL'|tr}:";}
  td:nth-of-type(3):before { content:"{'OP_CUSTOMER_ORDER_DATE'|tr}:";}
  td:nth-of-type(4):before { content:"{'OP_CUSTOMER_ORDER_STATUS'|tr}:";}
}
</style>