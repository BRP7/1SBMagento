<?php
class Ccc_Brand_Model_Brand extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('eav/entity_attribute_option'); // Initialize the model to interact with eav_attribute_option table
    }
}
