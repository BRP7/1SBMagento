<?php

class  Ccc_Outlook_Model_Resource_Configuration extends Mage_Core_Model_Resource_Db_Abstract{

    public function _construct(){
        $this->_init('practice_outlook/configuration','configuration_id');
    }
}