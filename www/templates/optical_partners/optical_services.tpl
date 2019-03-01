<div class="inner-wrapper op-wrapper">
  <div>
    <button onclick="window.history.back();" class="button button-primary float-right">{'OP_SERVICES_BTN_BACK'|tr}</button>
    <h1>{'OP_SERVICES_TITLE'|tr}</h1>
    <p>{'OP_SERVICES_INTRO'|tr}</p>
  </div>
  {foreach $services item=service key=k}
    {if $k != 'OP_SERVICE_6'}
      <h3><strong>{$service.name}</strong></h3>
      <p>{$service.description}</p>
    {/if}
  {/foreach}
</div>