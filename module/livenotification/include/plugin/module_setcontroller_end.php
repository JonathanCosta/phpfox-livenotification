<?php

if (phpfox::isModule('livenotification')) {
    phpfox::getLib('template')->setHeader(array(
        'core.js'   => 'module_livenotification',
        'core.css'  => 'module_livenotification'
    ));
}

?>