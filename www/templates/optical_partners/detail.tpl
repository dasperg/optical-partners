<script>
  window.trans = {};
  window.trans.BOOKING_TIME_PROMPT = "{'BOOKING_TIME_PROMPT'|tr}";
  window.trans.BOOKING_LOGIN_PROMPT = "{'BOOKING_LOGIN_PROMPT'|tr}";
</script>

{* Following javascripts are necesary for correct working of routing and appointment process *}
{include file="vue_components/calendar.tpl"}

<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>

<div id="app" class="inner-wrapper op-wrapper">
  <div class="partner-banner" style="background-image: url('/{$smarty.const.DIR_WS_IMAGES}optical_partners/{$store.image}')">
    <div class="row">
      <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
        <div class="partner-logo-wrap">
          <figure class="partner-logo" style="background-image: url('/{$smarty.const.DIR_WS_IMAGES}optical_partners/{$store.logo}')"></figure>
          <data value="{$store.website}" style="display:none;">{$store.website}</data>
        </div>
      </div>
      <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
        <h1 class="partner-heading">{$store.name}</h1>
      </div>
    </div>
  </div>

  <ol class="partner-breadcrumb divider-header" vocab="http://schema.org/" typeof="BreadcrumbList">
    <li property="itemListElement" typeof="ListItem">
      <span property="name"><a href="{'optical_partners_overview.php'|tep_href_link}">{'OP_BREADCRUMB_START'|tr}</a></span>
      <meta property="position" content="1">
    </li>
    <li property="itemListElement" typeof="ListItem">
      <span property="name">{$store.name}</span>
      <meta property="position" content="2">
    </li>
  </ol>

  <div class="row">
    <div class="col col--lg-3 col--lmd-4 col--md-12 col--sm-12">
      <ul class="partner-submenu">
        {foreach $content as $key => $item}
          {if $item.path != '/'} 
            <router-link to="{$item.path}" tag="li" active-class="active">
              <a {if $item.path == '/contact'}onclick="showMap();initMap();"{else}onclick="hideMap();"{/if}>{'OP_SECTION_'|cat:$item.path|replace:'/':''|upper|tr}</a>
            </router-link>
          {/if}
        {/foreach}
      </ul>
      {if count($store.hours.regular) > 0}
        <p class="divider-header">{'OP_HOUR_REGULAR'|tr}</p>
        <div class="block-centered col--sm-12">
          <table class="opening-hours">
            <tbody>
              {foreach $store.hours.regular key=weekday item=hour}
                <tr>
                  <td><strong>{'OP_HOUR_DAY_'|cat:$weekday|tr}</strong></td>
                  <td class="hours">
                    {foreach $hour item=hour_item key=j}
                      {$hour_item.starts_at|substr:0:5} - {$hour_item.ends_at|substr:0:5}
                      <br />
                    {/foreach}
                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        </div>
      {/if}
      {if count($store.hours.special) > 0}
        {foreach $store.hours.special key=key_date item=date}
          {foreach $date key=key_hours item=hours}
            {if isset($special[$key_hours])}
              {$special[$key_hours]['date_to'] = $key_date}
            {else}
              {$special[$key_hours]['date_from'] = $key_date}
              {$special[$key_hours]['starts_at'] = $hours.starts_at}
              {$special[$key_hours]['ends_at'] = $hours.ends_at}
              {$special[$key_hours]['remark'] = $hours.description.remark}
              {$special[$key_hours]['id'] = $key_hours}
            {/if}
          {/foreach}
        {/foreach}
        <p class="divider-header">{'OP_HOUR_SPECIAL'|tr}</p>
        <div class="block-centered col--sm-12">
          <table class="opening-hours">
            <tbody>
              {assign var=previous_special value=""}
              {assign var=isGroupWithPrevious value=false}
              {foreach $special key=j item=hour}
                {if $previous_special == $hour.remark[$smarty.session.languages_id].content|cat:$hour.date_from|cat:$hour.date_to}
                  {assign var=isGroupWithPrevious value=true}
                {else}
                  {assign var=isGroupWithPrevious value=false}
                {/if}
                {if $hour.remark[$smarty.session.languages_id].content != '' && !$isGroupWithPrevious}
                  <tr class="remark">
                    <td colspan="2">
                      <div class="content">{$hour.remark[$smarty.session.languages_id].content}</div>
                    </td>
                  </tr>
                {/if}
                <tr>
                  <td>
                    {if !$isGroupWithPrevious}
                      <strong>{$hour.date_from|date_format:'%d.%m.%Y'} {if isset($hour.date_to)} - {$hour.date_to|date_format:'%d.%m.%Y'}{/if}</strong>
                    {/if}
                  </td>
                  <td class="hours">{$hour.starts_at|substr:0:5} - {$hour.ends_at|substr:0:5}<br /></td>
                </tr>
                {assign var=previous_special value=$hour.remark[$smarty.session.languages_id].content|cat:$hour.date_from|cat:$hour.date_to}
              {/foreach}
            </tbody>
          </table>
        </div>
      {/if}
    </div>
    <div class="col col--lg-9 col--lmd-8 col--md-12 col--sm-12">
      <router-view></router-view>
      <div id="map-contact" class="op-content-with-menu" style="display:none"></div>
      <div class="preloader"><span></span></div>
      <data id="dataBookingId" value="{if isset($smarty.get.booking)}{$smarty.get.booking}{else}0{/if}"></data>
      <data id="dataServicesId" value="{if isset($smarty.get.service)}{$smarty.get.service}{else}0{/if}"></data>
      <data id="dataCustomerId" value="{$smarty.get.customer}"></data>
    </div>
  </div>
</div>
{* Following javascripts are necesary for correct working of routing and appointment process *}

<script>
  var partnerRoutes = {$content|json_encode};
  Vue.options.delimiters = ['<%', '%>'];
  var startHours = '{$hoursStartsAt}';
  var cellLength = 30;
</script>

{if $smarty.const.PROJECT_STATUS == 'live'}
<script src="{'optical_partner_detail.compiled.min.js'|getLastModified}"></script>
{else}
<script src="{'optical_partner_detail.compiled.js'|getLastModified}"></script>
{/if}