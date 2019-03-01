{if count($partner->stores.$storeId.hours.regular) > 0}
  <h4>{'OP_HOUR_REGULAR'|tr}</h4>
  <div class="block-centered">
    <table class="opening-hours">
      <tbody>
        {foreach $partner->stores.$storeId.hours.regular key=weekday item=hour}
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