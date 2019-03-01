<div class="inner-wrapper op-wrapper">
  {include file="optical_partners/admin/_includes/breadcrumbs.tpl"}
  <h2 style="margin-top: 15px !important;">{'OP_FE_ADMIN_MY_CUSTOMERS'|tr}</h2>

  {if $smarty.get.action == 'createAddressForm' && !empty($smarty.get.customer)}
  <div class="row m-b-lg">
    <div class="col col--md-12 col--sm-12">
      <ul class="partner-submenu">
        <li>
          <span>{'OP_CUSTOMER_ADDRESS_CREATE_HEADER'|tr}: {$address.customers_firstname} {$address.customers_lastname}</span>
        </li>
      </ul>
      <form action="{'op_admin_customers.php'|tep_href_link:'':'SSL'}" method="post" id="address-create">
        <input type="hidden" name="action" value="createAddressSave" />
        <input type="hidden" name="customers_id" value="{$smarty.get.customer}" />
        <input type="hidden" name="address_book_id" value="1" />
        <input type="hidden" name="entry_firstname" value="{$address.customers_firstname}" />
        <input type="hidden" name="entry_lastname" value="{$address.customers_lastname}" />
        <input type="hidden" name="entry_country_id" value="204" />
        <div class="row">
          <div class="col col--md-6 col--sm-12">
            <div class="form-flow-inline">
              <div class="form-row">
                <label class="form-row-label">{'ENTRY_GENDER'|tr|replace:':':''}</label>
                <input type="radio" class="form-radio" name="entry_gender" value="m" id="gender_m" checked="checked" / >
                <label for="gender_m" class="label-radio">{'MALE'|tr|replace:':':''}</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" class="form-radio" name="entry_gender" id="gender_f" value="f" />
                <label for="gender_f" class="label-radio">{'FEMALE'|tr|replace:':':''}</label>
              </div>
              <div class="form-row">
                <label class="form-row-label">{'ENTRY_FIRST_NAME'|tr|replace:':':''}</label>
                <input type="text" name="entry_firstname" value="{$address.customers_firstname}" disabled="disabled" />
              </div>
              <div class="form-row">
                <label class="form-row-label">{'ENTRY_LAST_NAME'|tr|replace:':':''}</label>
                <input type="text" name="entry_lastname" value="{$address.customers_lastname}" disabled="disabled" />
              </div>
              <div class="form-row">
                <label class="form-row-label">{'ENTRY_COMPANY'|tr|replace:':':''}</label>
                <input type="text" name="entry_company" value="" placeholder="--- {'OP_CUSTOMER_ADDRESS_OPTIONAL_FIELD'|tr} ---" />
              </div>
            </div>
          </div>
          <div class="col col--md-6 col--sm-12">
            <div class="form-flow-inline">
              <div class="form-row">
                <label class="form-row-label">&nbsp;</label>
                <em>{'MANDATORY_FIELDS'|tr}</em>
              </div>
              <div class="ac-block">
                <div class="form-row">
                  <label class="form-row-label">{'ENTRY_STREET_ADDRESS'|tr|replace:':':''} *</label>
                  <input type="text" name="entry_street_address" value="" />
                </div>
              </div>
              <div class="ac-block">
                <div class="form-row">
                  <label class="form-row-label">{'ENTRY_POST_CODE'|tr|replace:':':''} *</label>
                  <input type="text" name="entry_postcode" value="" />
                </div>
              </div>
              <div class="ac-block">
                <div class="form-row">
                  <label class="form-row-label">{'ENTRY_CITY'|tr|replace:':':''} *</label>
                  <input type="text" name="entry_city" value="" />
                </div>
              </div>
              <div class="form-row">
                <label class="form-row-label"></label>
                <button class="button-primary button-full">{'OP_CUSTOMER_ADDRESS_BTN_SUBMIT'|tr}</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <hr />
  {/if}

  <div class="row">
    <div class="col col--lg-4 col--md-12 col--sm-12">
      <ul class="partner-submenu">
        <li class="">
          <span>{'OP_CUSTOMER_SEARCH'|tr}</span>
        </li>
      </ul>
      <form>
        <input type="hidden" name="all" value="{$smarty.get.all}">
        <input type="hidden" name="store_customers" value="1">
        <div class="form-flow-inline">
          <div class="form-row">
            <label class="form-row-label">{'OP_CUSTOMER_FIRST_NAME'|tr}</label>
            <input type="text" name="search[firstname]" value="{$smarty.get.search.firstname}" placeholder="">
          </div>
          <div class="form-row">
            <label class="form-row-label">{'OP_CUSTOMER_LAST_NAME'|tr}</label>
            <input type="text" name="search[lastname]" value="{$smarty.get.search.lastname}" placeholder="">
          </div>
          <div class="form-row">
            <label class="form-row-label"></label>
            <button class="button-primary button-full">{'OP_CUSTOMER_BTN_SEARCH'|tr}</button>
          </div>
        </div>
      </form>


      <ul class="partner-submenu m-t-lg">
        <li class="">
          <span>{'OP_CUSTOMER_SEARCH_OVER_BRAND'|tr}</span>
        </li>
      </ul>
      <form>
        <input type="hidden" name="brand_customers" value="1">
        <div class="form-flow-inline">
          <div class="form-row">
            <label class="form-row-label">{'OP_CUSTOMER_FIRST_NAME'|tr}</label>
            <input type="text" name="search[c.customers_firstname]" value="{$smarty.get.search['c.customers_firstname']}" placeholder="" required>
          </div>
          <div class="form-row">
            <label class="form-row-label">{'OP_CUSTOMER_LAST_NAME'|tr}</label>
            <input type="text" name="search[c.customers_lastname]" value="{$smarty.get.search['c.customers_lastname']}" placeholder="" required>
          </div>
          <div class="form-row">
            <label class="form-row-label">{'OP_CUSTOMER_CITY'|tr}</label>
            <input type="text" name="search[ab.entry_city]" value="{$smarty.get.search['ab.entry_city']}" placeholder="" required>
          </div>
          <div class="form-row">
            <label class="form-row-label"></label>
            <button class="button-primary button-full">{'OP_CUSTOMER_BTN_SEARCH'|tr}</button>
          </div>
          <hr />
          <div class="form-row">
            <a href="{'create_account.php'|tep_href_link}" class="button-secondary button-full">{'OP_CUSTOMER_BTN_CREATE_CUSTOMER'|tr}</a>
          </div>
          
        </div>
      </form>
    </div>

    <div class="col col--lg-8 col--md-12 col--sm-12">

      <div class="op-content-with-menu">
        {if count($customers) > 0}
        <table class="table optical-table">
          <thead>
            <th colspan="3">
              {if $smarty.get.brand_customers == 1}
                {'OP_CUSTOMER_SEARCH_OVER_BRAND'|tr}
              {else}
                {'OP_CUSTOMER_LIST'|tr}

                {if !$smarty.get.all}
                  <form name="form-customers-all" action="{$SCRIPT_NAME}" method="get" class="float-right">
                    <input id="all" name="all" type="checkbox" onchange="this.form.submit()" style="display:block;margin-top:3px;float:left;"/><label for="all">{'OP_CUSTOMER_LIST_ALL'|tr}</label>
                  </form>
                {else}
                  <form name="form-customers-all" action="{$SCRIPT_NAME}" method="get" class="float-right">
                    <input id="all" name="all" type="checkbox" value="true" checked="checked" onchange="this.form.submit()" style="display:block;margin-top:3px;float:left;"/><label for="all">{'OP_CUSTOMER_LIST_ALL'|tr}</label>
                  </form>
                {/if}
              {/if}
            </th>
          </thead>
          <tbody>
          {foreach from=$customers item=customer}
            <tr>
              <td>{$customer.customers_firstname} {$customer.customers_lastname}</td>
              <td>
                {if $customer.entry_street_address && $customer.entry_city && $customer.entry_postcode && $customer.entry_city}
                  {$customer.entry_street_address}, {$customer.entry_postcode} {$customer.entry_city} 
                {else}
                  <em style="color: gray"><small>{'OP_CUSTOMER_NO_ADDRESS'|tr}</small></em>
                {/if}
                <br />
                {$customer.customers_email_address}{if $customer.customers_telephone}, {$customer.customers_telephone}{/if}
              </td>
              <td class="button-action right">
                {if isset($customer.stores) && !in_array($storeId, $customer.stores)}
                  <a href="{'op_admin_customers.php'|tep_href_link}?entity=customer&customer={$customer.customers_id}&action=assign" class="{if count($customer.stores)}takeOverButton{/if} button button-primary display-inline-block">{if (count($customer.stores))}  {'OP_CUSTOMER_BTN_TAKE_OVER_CUSTOMER'|tr}{else}{'OP_CUSTOMER_BTN_ASSIGN_CUSTOMER'|tr}{/if}</a>
                {else}
                  <a href="{'op_admin_customers.php'|tep_href_link}?section=detail&entity=customer&customer={$customer.customers_id}" class="button button-primary display-inline-block">{'OP_CUSTOMER_DETAIL'|tr}</a>
                  <a href="{'op_admin_customers.php'|tep_href_link}?action=makeOrder&customer={$customer.customers_id}" class="button button-primary display-inline-block">{'OP_CUSTOMER_MAKE_ORDER'|tr}</a>
                {/if}
              </td>
            </tr>
          {/foreach}
          </tbody>
        </table>
        {else}
          <div class="message_stack-warning" style="margin-top: 0;">{'OP_CUSTOMER_NO_RESULTS'|tr}</div>
        {/if}
      </div>
    </div>
  </div>
</div>

<div id="takeContent" style="display: none;">{'OP_CUSTOMER_TAKE_OVER_CUSTOMER_PROMPT'|tr}</div>
<div id="takeFooter" style="display: none;">
  <button class="button button-tertiary" hide_on_click="true">{'OP_CUSTOMER_BTN_CANCEL'|tr}</button>
  <a id="take-link" href="#" class="button button-primary float-right">{'OP_CUSTOMER_BTN_CONFIRM'|tr}</a>
</div>

<script>
$('body').on('click', '.takeOverButton', function(e) {
  e.preventDefault();
  document.getElementById('take-link').href = $(this).attr('href');
  $Vmodal.makeFull(
    "{'OP_CUSTOMER_BTN_TAKE_OVER_CUSTOMER'|tr}",
    document.getElementById('takeContent').innerHTML,
    document.getElementById('takeFooter').innerHTML,
    false);
});

$(document).ready(function () {
  $('#address-create').validate({
    errorClass: "validation-error",
    errorPlacement: function(error, element) {
      error.appendTo(element.parents('.ac-block'));
    },
    rules: {
      'entry_street_address': {
        required: true
      },
      'entry_postcode': {
        required: true
      },
      'entry_city': {
        required: true
      }
    }
  });
});
</script>