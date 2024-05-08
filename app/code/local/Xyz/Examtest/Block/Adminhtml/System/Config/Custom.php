<?php
class Xyz_Examtest_Block_Adminhtml_System_Config_Custom extends Mage_Adminhtml_Block_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('xyz/examtest/custom.phtml');
    }

}
