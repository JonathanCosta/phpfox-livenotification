<?php

defined('PHPFOX') or exit('NO DICE!');

class Livenotification_Component_Block_Notifications extends Phpfox_Component {

    public function process() {
        $aNotifications = phpfox::getService('livenotification.notification')->getNotifications();
        if (!count($aNotifications)) return false;
        $this->template()->assign(array(
            'aNotifications' => $aNotifications
        ));
    }

}