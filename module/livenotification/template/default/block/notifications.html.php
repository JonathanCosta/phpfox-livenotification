<?php
defined('PHPFOX') or exit('NO DICE!');
?>
{foreach from=$aNotifications key=iKey item=aNotification}
<div class="ln-item">
    <div class="fl user_image"> 
        {img user=$aNotification suffix='_50_square' max_width=50 max_height=50}
    </div>
    <div class="fl item_info">
        <div class="">
            <span>{$aNotification.message}</span>
        </div>
        <div class="time_like">
            <div class="fl time_stamp"><span>{$aNotification.time_stamp|convert_time}</span></div>
            <div class="cl"></div>
        </div>
    </div>    
    <a class="close_notification" href="javascript:void(o);" onclick="$(this).parent().remove(); return false;"><img src="{param var='core.path'}theme/frontend/default/style/default/image/layout/friend_action_delete.png"></a>
    <div class="cl"></div>
</div>
{/foreach}
