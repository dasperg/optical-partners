<ul class="partner-submenu">
  {foreach name=submenu from=$submenu item=item}
    <li {(in_array($smarty.get.section, $item.activeSection) || (!$smarty.get.section && $smarty.foreach.submenu.first)) ? 'class="active"' : ''}>
      <a href="{$SCRIPT_NAME|tep_href_link:$item.link}">{$item.title|tr}</a>
    </li>
  {/foreach}
</ul>