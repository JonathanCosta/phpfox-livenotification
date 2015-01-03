<?php

defined('PHPFOX') or exit('NO DICE!');

class Livenotification_Component_Block_Notifications extends Phpfox_Component {

    public function process() {
        $this->template()->assign(array(
            'aNotifications' => $this->getParam('aNotifications')
        ));
    }

}