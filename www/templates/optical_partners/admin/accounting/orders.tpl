<div class="inner-wrapper op-wrapper">

    {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

    <div class="row">
        <div class="col col--sm-12">
            <h2>{$pageTitle|tr}</h2>
            <h5>{'OP_CURRENT_PERIOD'|tr}</h5>
            {if count($orders.current) > 0}
                <table class="table optical-table responsive-table">
                    <thead>
                    <tr class="tr">
                        <th class="th">{'OP_ORDER_NUMBER'|tr}</th>
                        <th class="th">{'OP_ORDER_CUSTOMER'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_STATUS'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_DATE'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_TOTAL'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_COMMISSION'|tr}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$orders.current item=order key=orderId}
                        <tr class="tr">
                            <td class="td-detail">
                                {if count($order.items)}
                                    <label class="detail__label" for="order_{$orderId}" onclick="toogleDetail(this,'order_{$orderId}_content')">+</label>
                                {/if}
                                <a href="{'op_admin_customers.php'|tep_href_link}?section=orderDetail&entity=customer&customer={$order.customers_id}&order={$orderId}" {if !count($order.items)}style="margin-left: 27px;"{/if}>{$orderId}</a>
                            </td>
                            <td class="td-detail">
                                <a href="{'op_admin_customers.php'|tep_href_link}?section=orders&entity=customer&customer={$order.customers_id}">{$order.customer}</a>
                            </td>
                            <td class="td-detail text-right">{$order.status|tr}</td>
                            <td class="td-detail text-right">{$order.date_purchased|date_format:'%d.%m.%Y'}</td>
                            <td class="td-detail text-right">{'OP_CURRENCY_CHF'|tr} {$order.total_value|string_format:"%.2f"}</td>
                            <td class="td-detail text-right"><strong>{'OP_CURRENCY_CHF'|tr} {$order.commission|string_format:"%.2f"}</strong></td>
                        </tr>
                        {if count($order.items) > 0}
                            <tr id="order_{$orderId}_content" class="tr" style="display:none;">
                                <td class="p-no" colspan="6">
                                    <div class="detail__content" style="padding-left: 35px">
                                        {foreach from=$order.items item=item}
                                            <div class="row" style="border-bottom: 1px dotted lightgrey; padding: 5px 0;">
                                                <div class="col col--md-8 col--sm-12">{$item.products_quantity}x&nbsp;&nbsp;&nbsp;{$item.products_name}&nbsp;&nbsp;&nbsp;&nbsp; <small>({'OP_UNIT_PRICE'|tr}: {'OP_CURRENCY_CHF'|tr} {$item.products_price|string_format:"%.2f"})</small></div>
                                                <div class="col col--md-4 col--sm-12 text-right">{'OP_CURRENCY_CHF'|tr} {$item.amount|string_format:"%.2f"}</div>
                                            </div>
                                        {/foreach}
                                    </div>
                                </td>
                            </tr>
                        {else}
                            <tr class="tr" style="display:none;"></tr>
                        {/if}
                    {/foreach}
                    </tbody>
                </table>
            {else}
                <div class="message_stack-warning">{'OP_ACCOUNTING_NO_ORDERS'|tr}</div>
            {/if}

            <h5>{'OP_PREVIOUS_PERIODS'|tr}</h5>
            {if count($orders.previous) > 0}
                <table class="table optical-table responsive-table">
                    <thead>
                    <tr class="tr">
                        <th class="th">{'OP_ORDER_NUMBER'|tr}</th>
                        <th class="th">{'OP_ORDER_CUSTOMER'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_STATUS'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_DATE'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_TOTAL'|tr}</th>
                        <th class="th text-right">{'OP_ORDER_COMMISSION'|tr}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$orders.previous item=order key=orderId}
                        <tr class="tr">
                            <td class="td-detail">
                                {if count($order.items)}
                                    <label class="detail__label" for="order_{$orderId}" onclick="toogleDetail(this,'order_{$orderId}_content')">+</label>
                                {/if}
                                <a href="{'op_admin_customers.php'|tep_href_link}?section=orderDetail&entity=customer&customer={$order.customers_id}&order={$orderId}" {if !count($order.items)}style="margin-left: 27px;"{/if}>{$orderId}</a>
                            </td>
                            <td class="td-detail">
                                <a href="{'op_admin_customers.php'|tep_href_link}?section=orders&entity=customer&customer={$order.customers_id}">{$order.customer}</a>
                            </td>
                            <td class="td-detail text-right">{$order.status|tr}</td>
                            <td class="td-detail text-right">{$order.date_purchased|date_format:'%d.%m.%Y'}</td>
                            <td class="td-detail text-right">{'OP_CURRENCY_CHF'|tr} {$order.total_value|string_format:"%.2f"}</td>
                            <td class="td-detail text-right"><strong>{'OP_CURRENCY_CHF'|tr} {$order.commission|string_format:"%.2f"}</strong></td>
                        </tr>
                        {if count($order.items) > 0}
                            <tr id="order_{$orderId}_content" class="tr" style="display:none;">
                                <td class="p-no" colspan="6">
                                    <div class="detail__content" style="padding-left: 35px">
                                        {foreach from=$order.previous_commissions item=item name=clearance}
                                            {if not $smarty.foreach.clearance.last}
                                                <div class="row" style="border-bottom: 2px dotted grey; padding: 5px 0;">
                                                    <div class="col col--md-8 col--sm-12"><strong>{$item.period}</strong></div>
                                                    <div class="col col--md-4 col--sm-12 text-right">{'OP_CURRENCY_CHF'|tr} {$item.commission|string_format:"%.2f"}</div>
                                                </div>
                                            {/if}
                                        {/foreach}
                                        {foreach from=$order.items item=item}
                                            <div class="row">
                                                <div class="col col--md-8 col--sm-12"><span class="m-r-md">{$item.products_quantity}x</span>{$item.products_name}<small class="m-l-md">({'OP_UNIT_PRICE'|tr}: {'OP_CURRENCY_CHF'|tr} {$item.products_price|string_format:"%.2f"})</small></div>
                                                <div class="col col--md-4 col--sm-12 text-right">{'OP_CURRENCY_CHF'|tr} {$item.amount|string_format:"%.2f"}</div>
                                            </div>
                                        {/foreach}
                                    </div>
                                </td>
                            </tr>
                        {/if}
                    {/foreach}
                    </tbody>
                </table>
            {else}
                <div class="message_stack-warning">{'OP_ACCOUNTING_NO_ORDERS'|tr}</div>
            {/if}

            <h5>{'OP_ACCOUNTING_SUMMARY'|tr}</h5>
            <table class="table optical-table responsive-table">
                <tbody>
                    <tr class="tr">
                        <td colspan="5" class="th text-right">&nbsp;</td>
                        <td class="th text-right">{'OP_CURRENCY_CHF'|tr} {$orders.summary.total_value|string_format:"%.2f"}</td>
                        <td class="th text-right"><strong>{'OP_CURRENCY_CHF'|tr} {$orders.summary.commission|string_format:"%.2f"}</strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="m-t-sm text-right">{$paginationLinks}</div>

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