<div class="inner-wrapper op-wrapper">

  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}
  <data id="customerId" value="{$smarty.get.customer}"></data>

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
        {include file="optical_partners/admin/_includes/submenu.tpl"}
    </div>

    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <div class="op-content-with-menu">
        <h2>{$pageTitle|tr}</h2>
          {include file="optical_partners/admin/_includes/calendar.tpl"}
      </div>
    </div>

  </div>
</div>