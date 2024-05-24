<?php

class Practice_Reportmanager_Model_Resource_Reportmanager extends Mage_Core_Model_Resource_Db_Abstract{

    public function _construct(){
        $this->_init('practice_reportmanager/reportmanager','id');
    }

}