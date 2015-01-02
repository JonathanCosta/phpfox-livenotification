<?php

defined('PHPFOX') or exit('NO DICE!');

class Livenotification_Service_Notification extends Phpfox_Service {

    protected $_sTableLive;

    public function __construct() {
        $this->_sTable = phpfox::getT('notification');
        $this->_sTableLive = phpfox::getT('notification_live');
    }

    public function getNotifications($iUserId = NULL) {
        if (!$iUserId)
            $iUserId = phpfox::getUserId();

        $aNotifications = $this->database()->select('n.*, n.user_id as item_user_id, COUNT(n.notification_id) AS total_extra, ' . Phpfox::getUserField())
                ->from($this->_sTable, 'n')
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = n.owner_user_id')
                ->leftJoin($this->_sTableLive, 'l', 'l.notification_id = n.notification_id')
                ->where(array(
                    ' AND n.user_id = ' . (int) $iUserId,
                    ' AND (l.is_seen is NULL OR l.is_seen = 0)'
                ))
                ->group('n.type_id, n.item_id')
                ->order('n.is_seen ASC, n.time_stamp DESC')
                ->limit(5)
                ->execute('getSlaveRows');

        if (count($aNotifications)) {
            foreach ($aNotifications as $i => $aNotification) {
                $aNotifications[$i] = $this->getExtra($aNotification);
                if (!$aNotifications[$i]) {
                    $this->database()->delete($this->_sTable, 'notification_id = ' . (int) $aNotification['notification_id']);
                }
            }
        }

        return $aNotifications;
    }

    public function getExtra($aRow) {
        $aParts1 = explode('.', $aRow['type_id']);
        $sModule = $aParts1[0];
        if (strpos($sModule, '_')) {
            $aParts = explode('_', $sModule);
            $sModule = $aParts[0];
        }

        if (Phpfox::isModule($sModule)) {
            if ((int) $aRow['total_extra'] > 1) {
                $aExtra = $this->database()->select('n.owner_user_id, n.time_stamp, n.is_seen, u.full_name')
                        ->from($this->_sTable, 'n')
                        ->join(Phpfox::getT('user'), 'u', 'u.user_id = n.owner_user_id')
                        ->where('n.type_id = \'' . $this->database()->escape($aRow['type_id']) . '\' AND n.item_id = ' . (int) $aRow['item_id'])
                        ->group('u.user_id')
                        ->order('n.time_stamp DESC')
                        ->limit(10)
                        ->execute('getSlaveRows');

                foreach ($aExtra as $iKey => $aExtraUser) {
                    if ($aExtraUser['owner_user_id'] == $aRow['user_id']) {
                        unset($aExtra[$iKey]);
                    }

                    if (!$aRow['is_seen'] && $aExtraUser['is_seen']) {
                        unset($aExtra[$iKey]);
                    }
                }

                if (count($aExtra)) {
                    $aRow['extra_users'] = $aExtra;
                }
            }

            if (substr($aRow['type_id'], 0, 8) != 'comment_' && !Phpfox::hasCallback($aRow['type_id'], 'getNotification')) {
                $aCallBack['link'] = '#';
                $aCallBack['message'] = '2. Notification is missing a callback. [' . $aRow['type_id'] . '::getNotification]';
            } elseif (substr($aRow['type_id'], 0, 8) == 'comment_' && substr($aRow['type_id'], 0, 12) != 'comment_feed' && !Phpfox::hasCallback(substr_replace($aRow['type_id'], '', 0, 8), 'getCommentNotification')) {
                $aCallBack['link'] = '#';
                $aCallBack['message'] = 'Notification is missing a callback. [' . substr_replace($aRow['type_id'], '', 0, 8) . '::getCommentNotification]';
            } else {
                $aCallBack = Phpfox::callback($aRow['type_id'] . '.getNotification', $aRow);
                $aRow['final_module'] = Phpfox::getLib('module')->sFinalModuleCallback;
                if ($aRow['final_module'] == 'photo') {
                    $aCallBack['link'] = $aCallBack['link'] . 'userid_' . Phpfox::getUserId() . '/';
                }

                if ($aCallBack === false) {
                    return false;
                }
            }
            
            $aRow = array_merge($aRow, (array) $aCallBack);
        }
        
        return $aRow;
    }

}
