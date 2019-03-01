<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--sm-12">
      <h2>{$pageTitle|tr}</h2>
      <form method="get" class="m-b-sm">
        <input type="hidden" name="action" value="detail">
        <input type="hidden" name="entity" value="order">
        <input type="text" name="orders_id" value="{$smarty.get.orders_id}" class="form-control">
        <input type="submit" class="button button-primary" value="{'OP_ORDER_BTN_SEARCH'|tr}">
      </form>
      {if count($orders) > 0}
        <table class="table optical-table responsive-table">
          <thead>
            <tr class="tr">
              <th class="th">{'OP_ORDER_NUMBER'|tr}</th>
              <th class="th">{'OP_ORDER_CUSTOMER'|tr}</th>
              <th class="th">{'OP_ORDER_STATUS'|tr}</th>
              <th class="th text-right">{'OP_ORDER_DATE'|tr}</th>
              <th class="th text-right">{'OP_ORDER_TOTAL'|tr}</th>
              <th class="th text-right">{'OP_ORDER_COMMISSION'|tr}</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$orders item=order key=orderId}
              <tr class="tr">
                <td class="td-detail">
                  {if count($order.packages)}
                    <label class="detail__label" for="order_{$orderId}" onclick="toogleDetail(this,'order_{$orderId}_content')">+</label>
                  {/if}
                  <a href="{'op_admin_customers.php'|tep_href_link}?section=orderDetail&entity=customer&customer={$order.customers_id}&order={$orderId}" {if !count($order.packages)}style="margin-left: 27px;"{/if}>{$orderId}</a>
                </td class="td-detail">
                <td class="td-detail">
                  <a href="{'op_admin_customers.php'|tep_href_link}?section=orders&entity=customer&customer={$order.customers_id}">{$order.customer}</a>
                </td>
                <td class="td-detail">{$order.status|tr}</td>
                <td class="td-detail text-right">{$order.date_purchased|date_format:'%d.%m.%Y'}</td>
                <td class="td-detail text-right">{'OP_CURRENCY_CHF'|tr} {$order.total_value|string_format:"%.2f"}</td>
                <td class="td-detail text-right"><strong>{'OP_CURRENCY_CHF'|tr} {$order.commission|string_format:"%.2f"}</strong></td>
              </tr>
              {if count($order.packages) > 0}
                <tr id="order_{$orderId}_content" class="tr" style="display:none;">
                  <td class="p-no" colspan="6">
                    <div class="detail__content" style="margin-left: 30px">
                      {foreach from=$order.packages item=package}
                        <div class="row">
                          <div class="col col--md-6 col--sm-12">
                            <p><strong>{'OP_PACKAGE_TRACKING_ID'|tr}:</strong> {$package.tracking_number}</p>
                            <p><strong>{'OP_PACKAGE_CARRIER'|tr}:</strong> {$package.carrier}</p>
                            <p><strong>{'OP_PACKAGE_EXTNUMBER'|tr}:</strong> {$package.extunumber}</p>
                            <p><strong>{'OP_PACKAGE_STATUS'|tr}:</strong> {$package.status|tr}</p>
                          </div>
                          <div class="col col--md-6 col--sm-12">
                            <p>
                              {foreach from=$package.content item=product}
                                &bull;&nbsp;{$product.quantity}x&nbsp;&nbsp;&nbsp;{$product.products_name}<br>
                              {/foreach}
                            </p>
                          </div>
                          <div class="col col--md-12 col--sm-12">
                            <div class="float-right">
                              {if ($package.status == 'OP_PACKAGE_READY_FOR_PICKUP')}
                                <a href='{'op_admin_orders.php'|tep_href_link:'':'SSL'}?action=update&entity=package&package={$package.id}&status=OP_PACKAGE_PICKED_UP' class="button button-primary">
                                  {'OP_PACKAGE_PICKED_UP'|tr}
                                </a>
                              {elseif ($package.status == 'OP_PACKAGE_DELIVERED')}
                                {'OP_PACKAGE_DELIVERED_TO_CUSTOMER_ON'|tr}: {$package.delivered_at|date_format:'%d.%m.%Y'}
                              {elseif ($package.status == 'OP_PACKAGE_PICKED_UP')}
                                {'OP_PACKAGE_PICKED_UP_BY_CUSTOMER_ON'|tr}: {$package.delivered_at|date_format:'%d.%m.%Y'}
                              {elseif ($package.status == 'OP_PACKAGE_CANCELLED')}
                                <a href='{'op_admin_orders.php'|tep_href_link:'':'SSL'}?action=update&entity=package&package={$package.id}&status=OP_PACKAGE_RETURNED' class="button button-primary">
                                  {'OP_PACKAGE_RETURNED'|tr}
                                </a>
                              {/if}
                            </div>
                          </div>
                        </div>
                      {/foreach}
                    </div>
                  </td>
                </tr>
              {else}
                <tr></tr>
              {/if}
            {/foreach}
            {if count($summary)}
              <tr class="tr">
                <td colspan="4" class="th text-right">{'OP_ORDER_TOTALS'|tr}</td>
                <td class="th text-right">{'OP_CURRENCY_CHF'|tr} {$summary.total_value}</td>
                <td class="th text-right">{'OP_CURRENCY_CHF'|tr} {$summary.commission}</td>
              </tr>
            {/if}
          </tbody>
        </table>
        <div class="text-right m-t-sm">{$paginationLinks}</div>
      {else}
        <div class="message_stack-warning">{'OP_ORDER_NO_ORDERS'|tr}</div>
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
<script>
  function toogleDetail(element, targetId) {
    var detailBox = document.getElementById(targetId);
    detailBox.style.display = detailBox.style.display === 'none' ? '' : 'none';
    element.innerHTML = detailBox.style.display === 'none' ? '+' : '-';
  }
</script>