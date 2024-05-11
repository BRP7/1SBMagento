<?php

class Practice_Customgrid_Model_Resource_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct(){
        $this->_init('practice_customgrid/customgrid');
    }
}