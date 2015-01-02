<?php

if (phpfox::isModule('livenotification')) {
    phpfox::getLib('template')->setHeader(array(
        'core.js' => 'module_livenotification'
    ));
}

?>