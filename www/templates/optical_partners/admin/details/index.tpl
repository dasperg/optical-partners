<script>
window.onload = function() {
  document.body.className += " loaded ";
  var list = document.querySelectorAll('.dashitem');
  var animation = 'bounceIn';
  setTimeout(function(){
    list[0].classList.add(animation); 
  }, 400);
  setTimeout(function(){
    list[1].classList.add(animation); 
  }, 600);
  setTimeout(function(){
    list[2].classList.add(animation); 
  }, 800);
  setTimeout(function(){
    list[3].classList.add(animation); 
  }, 1000);
}
</script>


{assign var=store value=$partner->stores.$storeId}

<div class="inner-wrapper dashboard op-wrapper">
  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}
  <div class="row">
    <div class="col col--sm-12">
      <h2 style="margin-top: 15px !important;">{'OP_DETAILS_STORE_STATISTICS'|tr}</h2>
      <div class="dashrow">
        <div class="dashitem-container">
          {$store.links.services = ''}
          {$store.links.customers = 'op_admin_customers.php'|tep_href_link}
          {$store.links.bookings = 'op_admin_bookings.php'|tep_href_link}
          {$store.links.orders = 'op_admin_orders.php'|tep_href_link}
          {foreach from=$store.statistics item=item key=key name=name}
            {if $store.links[$key] ne ''}
              <a href="{$store.links[$key]}"><div class="dashitem animated">{$item}</div></a>
            {else}
              <div class="dashitem animated">{$item}</div>
            {/if}
          {/foreach}
        </div>
        <div class="dashitem-container">
          {foreach from=$store.statistics item=item key=key name=name}
            <div class="dashtitle">{'OP_DETAILS_STORE_STATS_'|cat:$key|upper|tr}</div>
          {/foreach}
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col col--sm-12">
      <h2 style="margin-top: 15px !important;">{'OP_DETAILS_STORE_DETAILS'|tr}</h2>
      {if $store.image}
        <img src="/{$smarty.const.DIR_WS_IMAGES}optical_partners/{$partner->stores.$storeId.image}">
      {/if}
    </div>
  </div>
  <div class="row">
    <div class="col col--sm-12 col--md-6 col--lg-3">
      <div class="tile tile-1">
        <h4>{'OP_DETAILS_BASIC'|tr}</h4>
        <img src="/{$smarty.const.DIR_WS_IMAGES}optical_partners/{$partner->stores.$storeId.logo}">
        <label>{'OP_DETAILS_STORE_NAME'|tr}</label>
        {$partner->stores.$storeId.name}<br />
        <label>{'OP_DETAILS_WEBSITE'|tr}</label>
        {$partner->stores.$storeId.website}<br />
      </div>
    </div>
    <div class="col col--sm-12 col--md-6 col--lg-3">
      <div class="tile tile-2">
        {include file="optical_partners/_includes/opening_hours_regular.tpl"}
      </div>
    </div>
    <div class="col col--sm-12 col--md-6 col--lg-3">
      <div class="tile tile-3">
        <h4>{'OP_DETAILS_LOCATION'|tr}</h4>
        <label>{'OP_DETAILS_ADDRESS'|tr}</label>
        {$partner->stores.$storeId.street}<br />
        {$partner->stores.$storeId.zip}
        {$partner->stores.$storeId.city}<br /><br />

        {if count($store.contacts)>0}
          {foreach from=$store.contacts item=item key=key}
            {if $item.private == 0}
              <label>{'OP_DETAILS_CONTACT'|tr}</label>
              {$item.name}<br />
              {$item.email}<br />
            {/if}
          {/foreach}
        {/if}
      </div>
    </div>
    <div class="col col--sm-12 col--md-6 col--lg-3">
      <div class="tile tile-4">
        <h4>{'OP_DETAILS_ACCOUNTING'|tr}</h4>
        <label>VAT ID</label>
        {$partner->stores.$storeId.vat_id}<br />
        <label>{'OP_DETAILS_BUSINESS_ID'|tr}</label>
        {$partner->stores.$storeId.business_id}<br />
        <label>{'OP_DETAILS_BANK_NAME'|tr}Bank name</label>
        {$partner->stores.$storeId.bank_name}<br />
        <label>{'OP_DETAILS_ACCOUNT_NAME'|tr}</label>
        {$partner->stores.$storeId.bank_account_name}<br />
        <label>{'OP_DETAILS_ACCOUNT_IBAN'|tr}</label>
        {$partner->stores.$storeId.bank_account_iban}<br />
      </div>
    </div>
  </div>
</div>