<?php

defined('PHPFOX') or exit('NO DICE!');

class Livenotification_Service_Callback extends Phpfox_Service {
    public function getGlobalNotifications() {
        Phpfox::getLib('ajax')->call('console.log("okay!!");');
    }
}