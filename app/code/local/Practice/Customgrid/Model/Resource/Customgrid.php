<?php

class  Practice_Customgrid_Model_Resource_Customgrid extends Mage_Core_Model_Resource_Db_Abstract{

    public function _construct(){
        $this->_init('customgrid/customgrid','customgrid_id');
    }
}