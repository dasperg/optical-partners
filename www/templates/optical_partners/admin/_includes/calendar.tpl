<script>
    window.trans = {};
    window.trans.BOOKING_TIME_PROMPT = "{'BOOKING_TIME_PROMPT'|tr}";
    window.trans.BOOKING_LOGIN_PROMPT = "{'BOOKING_LOGIN_PROMPT'|tr}";
</script>

{* Following javascripts are necesary for correct working of routing and appointment process *}
{include file="vue_components/calendar.tpl"}

<div class="row">
    <div class="col col--lg-12 col--lmd-8 col--md-12 col--sm-12" id="app">
        {if isset($wrapper) && $wrapper == true}
            <div class="row">
                <h2 class="col col--lg-4 col--md-5 col--sm-12">{$pageTitle|tr}</h2>
                {* Calendar Legend *}
                <div class="col col--lg-8 col--md-7 col--sm-12">
                    <ul class="appointment-legend right">
                        <li class="occupied">{'BOOKING_LEGEND_OCCUPIED'|tr}</li>
                        <li class="selected">{'BOOKING_LEGEND_SELECTED'|tr}</li>
                        <li class="free">{'BOOKING_LEGEND_FREE'|tr}</li>
                    </ul>
                </div>
            </div>
        {/if}

        <div class="preloader"><span></span></div>
        <data id="dataBookingId" value="{if isset($booking.id)}{$booking.id}{else}0{/if}"></data>
        <data id="dataServicesId" value="{if isset($booking.op_services_id)}{$booking.op_services_id}{else}0{/if}"></data>
        <data id="dataCustomerId" value="{$smarty.get.customer}"></data>

        <appointment-process :store-id="{$smarty.session.op_stores_id}" :services='{$services}' :admin="{if isset($smarty.session.op_stores_id)}true{else}false{/if}" ></appointment-process>
        <div id="map-contact" class="op-content-with-menu" style="display:none"></div>

    </div>
</div>

<script>
    Vue.options.delimiters = ['<%', '%>'];
    var startHours = '{$hoursStartsAt}';
    var cellLength = 30;
</script>

{if $smarty.const.PROJECT_STATUS == 'live'}
    <script src="{'optical_partner_detail.compiled.min.js'|getLastModified}"></script>
{else}
    <script src="{'optical_partner_detail.compiled.js'|getLastModified}"></script>
{/if}

<script>
    var app = new Vue({
        el: '#app',
        data: {
        }
    })
</script>