<div class="partner-site-header-space"></div>
<header class="site-header partner-site-header">
  <div class="site-header__center">
    <div class="inner-wrapper">
      {* Site logo *}
      <a href="{'/'|tep_href_link|escape}" title="{'H1_CONTENT'|tr}"><i class="svg-mrlens svg-mrlens-dims"></i></a>

      <nav class="partners-logoff caps">
        <ul>
          <li>
            <a href="{'logoff.php'|tep_href_link:'':'SSL'|escape}">{'OP_FE_ADMIN_LOGOUT'|tr}</a>
          </li>
        </ul>
      </nav>

      <div class="partners-languages">
        <ul>
          {foreach from=$languages item=language key=l_id name=langs}
            {if $l_id eq $languages_code}
              <li class="language--active">
                {$l_id|upper}
              </li>
            {else}
              <li>
                <a href="{$SCRIPT_NAME|basename|tep_href_link:$aLanguages[$l_id].link_get_params:$request_type|escape}" id="{$l_id}_{$aLanguages[$l_id].id}">{$l_id|upper}</a>
              </li>
            {/if}
          {/foreach}
        </ul>
      </div>
    </div>
  </div>

  {* Navigation *}

  <div class="site-header__bottom">
    <div class="inner-wrapper">
      {* Mobile nav toggle icon *}
      <span class="svg-menu svg-menu-dims"></span>
      
      <nav class="main-nav">
        <header>
          <div class="partners-languages partners-languages-mobile">
            <ul>
              {foreach from=$languages item=language key=l_id name=langs}
                {if $l_id eq $languages_code}
                  <li class="language--active">
                    {$l_id|upper}
                  </li>
                {else}
                  <li>
                    <a href="{$SCRIPT_NAME|basename|tep_href_link:$aLanguages[$l_id].link_get_params:$request_type|escape}" id="{$l_id}_{$aLanguages[$l_id].id}">{$l_id|upper}</a>
                  </li>
                {/if}
              {/foreach}
            </ul>
          </div>
          <span class="svg-cancel svg-cancel-dims"></span>
        </header>
        <div class="main-nav__in">
          <ul class="main-nav__top-list flex-wrapper">
            <li class="main-nav__item--level-0"><a href="{'op_admin_details.php'|tep_href_link}">{'OP_FE_ADMIN_DETAILS'|tr}</a></li>
            <li class="main-nav__item--level-0"><a href="{'op_admin_customers.php'|tep_href_link}">{'OP_FE_ADMIN_MY_CUSTOMERS'|tr}</a></li>
            <li class="main-nav__item--level-0"><a href="{'op_admin_orders.php'|tep_href_link}">{'OP_FE_ADMIN_ORDERS'|tr}</a></li>
            <li class="main-nav__item--level-0"><a href="{'op_admin_bookings.php'|tep_href_link}">{'OP_FE_ADMIN_BOOKING'|tr}</a></li>
            <li class="main-nav__item--level-0"><a href="{'op_admin_accounting.php'|tep_href_link}">{'OP_FE_ADMIN_ACCOUNTING'|tr}</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</header>