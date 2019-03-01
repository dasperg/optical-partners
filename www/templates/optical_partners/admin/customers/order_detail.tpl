<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
      {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>

    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <div class="op-content-with-menu">
        <div class="row">

          <div class="col col--sm-12">
            <h2>{'OP_CUSTOMER_ORDER_NUMBER'|tr}: {$order->id}</h2>
            <div class="order-detail">
              <p><strong class="w-200">{'OP_CUSTOMER_ORDER_STATUS'|tr}</strong> {$order->info.orders_status_name}</p>
              <p><strong class="w-200">{'OP_CUSTOMER_ORDER_DATE'|tr}</strong> {$order->info.date_purchased|date_format:'%d.%m.%Y'}</p>
              <p><strong class="w-200">{'OP_CUSTOMER_ORDER_TOTAL'|tr}</strong> {$order->info.total_text}</p>
            </div>
          </div>
          
          <div class="special_info_blocks col col--md-6 col--sm-12">
            <p class="order-detail-headline">{'OP_CUSTOMER_ORDER_SHIPPING_ADDRESS'|tr}</p>
            <p class="order-section">
              <div>{$order->delivery.name}</div>
              <div>{$order->delivery.street_address}</div>
              <div>{$order->delivery.postcode} {$order->delivery.city}</div>
              <div>{$order->delivery.country.title}</div>
            </p>
          </div>

          <div class="special_info_blocks col col--md-6 col--sm-12">
            <p class="order-detail-headline">{'OP_CUSTOMER_ORDER_SHIPPING_METHOD'|tr}</p>
            <p class="order-section">{$order->info.shipping_method}</p>
          </div>

          <div class="special_info_blocks col col--md-6 col--sm-12">
            <p class="order-detail-headline">{'OP_CUSTOMER_ORDER_BILLING_ADDRESS'|tr}</p>
            <p class="order-section">
              <div>{$order->billing.name}</div>
              <div>{$order->billing.street_address}</div>
              <div>{$order->billing.postcode} {$order->delivery.city}</div>
              <div>{$order->billing.country.title}</div>
            </p>
          </div>

          <div class="special_info_blocks col col--md-6 col--sm-12">
            <p class="order-detail-headline">{'OP_CUSTOMER_ORDER_BILLING_METHOD'|tr}</p>
            <p class="order-section">{$order->info.payment_method}</p>
          </div>

          <div class="special_info_blocks col col--sm-12">
            <table class="table optical-table responsive-table">
              <thead>
                <tr>
                  <th class="th">{'OP_CUSTOMER_ORDER_PRODUCTS'|tr}</th>
                  <th class="th text-right">{'OP_CUSTOMER_ORDER_QUANTITY'|tr}</th>
                  <th class="th text-right">{'OP_CUSTOMER_ORDER_PRICE'|tr}</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$order->products key=productId item=product}
                <tr>
                  <td class="td">
                    <div><strong>{$product.name}</strong></div>
                    {foreach from=$product.attributes item=attribute}
                      <small>{$attribute.option}: {$attribute.value}</small><br/>
                    {/foreach}
                  </td>
                  <td class="td text-right">{$product.qty}</td>
                  <td class="td text-right">{$order->info.currency} {$product.price|string_format:"%.2f"}</td>
                </tr>
                {/foreach}
                {foreach from=$order->totals item=total}
                <tr>
                  <td class="text-right" colspan="2">
                    <span>{$total.title}</span>
                  </td>
                  <td class="text-right">
                    <strong>{$total.text}</strong>
                  </td>
                </tr>
                {/foreach}
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>