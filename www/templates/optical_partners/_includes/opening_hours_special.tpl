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
  <div class="block-centered">
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