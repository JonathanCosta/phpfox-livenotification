<?php

defined('PHPFOX') or exit('NO DICE!');

class Livenotification_Component_Ajax_Ajax extends Phpfox_Ajax {
    public function check() {
        $aNotifications = phpfox::getService('livenotification.notification')->getNotifications();
        if (!count($aNotifications)) {
            $this->call('LN.options.onCheck = false;');
            return false;
        }
        $aIds = array();
        foreach ($aNotifications as $aNotification) {
            $aIds[] = $aNotification['notification_id'];
        }
        phpfox::getBlock('livenotification.notifications', array(
            'aNotifications' => $aNotifications
        ));
        $this->call('LN.attach("'.$this->getContent().'", '.  json_encode($aIds).');');
    }
    
    public function read() {
        $aIds = explode(',', $this->get('ids'));
        if (count($aIds)) {
            foreach ($aIds as $iId) {
                $iId = (int) trim($iId);
                phpfox::getService('livenotification.notification')->read($iId);
            }
        }
    }
}