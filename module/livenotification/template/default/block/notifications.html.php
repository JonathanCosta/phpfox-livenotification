<?php
defined('PHPFOX') or exit('NO DICE!');
?>
{foreach from=$aNotifications key=iKey item=aNotification}
<div class="ln-item">
    {img user=$aNotification suffix='_50_square' max_width=50 max_height=50}
</div>
{/foreach}