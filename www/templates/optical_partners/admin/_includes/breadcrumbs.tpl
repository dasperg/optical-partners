{if is_array($breadcrumbs)}
  <ol class="partner-breadcrumb divider-header" vocab="http://schema.org/" typeof="BreadcrumbList">
    {foreach from=$breadcrumbs item=item name=breadcrumbs}
      <li property="itemListElement" typeof="ListItem">
        <span property="name">
          {if isset($item.link)}
            <a href="{$SCRIPT_NAME|tep_href_link:$item.link}">{$item.title|tr}</a>
          {else}
            {$item.title|tr}
          {/if}
        </span>
        <meta property="position" content="1">
      </li>
    {/foreach}
  </ol>
{/if}