<?php

class Practice_Reportmanager_Model_Resource_Reportmanager_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{

    public function _construct(){
        $this->_init('practice_reportmanager/reportmanager');
    }
}