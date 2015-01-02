<?php

defined('PHPFOX') or exit('NO DICE!');

class Livenotification_Component_Ajax_Ajax extends Phpfox_Ajax {
    public function check() {
        phpfox::getBlock('livenotification.notifications');
        $this->call('LN.attach("'.$this->getContent().'")');
    }
}