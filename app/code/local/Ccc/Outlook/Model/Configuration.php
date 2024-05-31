<?php
class Ccc_Outlook_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'last_stored_email';
    protected $_eventObject = 'email';
    protected function _construct()
    {
        $this->_init('ccc_outlook/configuration');
    }
}
