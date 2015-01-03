<?php

if (phpfox::isModule('livenotification')) {
    phpfox::getLib('template')->setHeader(array(
        'core.js'   => 'module_livenotification',
        'core.css'  => 'module_livenotification'
    ));
    
    $iDelayCheck = (int) phpfox::getParam('livenotification.notification_check');
    $iDelayClean = (int) phpfox::getParam('livenotification.notification_clean');
    phpfox::getLib('template')->setHeader(array(
        '<script type="text/javascript">var ln_delay_check = '.$iDelayCheck.', ln_delay_clean = '.$iDelayClean.';</script>'
    ));
}

?>