<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
      {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>
    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <div class="op-content-with-menu">
        <h2>{$pageTitle|tr}</h2>
        <ul>
          <li class="m-t-xxs"><strong class="w-200">{'OP_CUSTOMER_FIRST_NAME'|tr}:</strong> {$customersInfo.customers_firstname}</li>
          <li class="m-t-xxs"><strong class="w-200">{'OP_CUSTOMER_LAST_NAME'|tr}:</strong> {$customersInfo.customers_lastname}</li>
          <li class="m-t-xxs">
            <strong class="w-200">{'OP_CUSTOMER_ADDRESS'|tr}:</strong>
            {if count($customersAddress)}
              {$customersAddress.entry_street_address}, {$customersAddress.entry_postcode} {$customersAddress.entry_city}
            {else}
              -----
            {/if}
          </li>
          <li class="m-t-xxs"><strong class="w-200">{'OP_CUSTOMER_EMAIL'|tr}:</strong> {$customersInfo.customers_email_address}</li>
          <li class="m-t-xxs"><strong class="w-200">{'OP_CUSTOMER_PHONE'|tr}:</strong> {$customersInfo.customers_telephone}</li>
          <li class="m-t-xxs"><strong class="w-200">{'OP_CUSTOMER_ASSIGNED_SINCE'|tr}:</strong> {$customer.starts_at|date_format: "%d.%m.%Y"}</li>
        </ul>
      </div>
    </div>
  </div>
</div>