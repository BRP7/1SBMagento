<?php
class Ccc_Locationcheck_Model_Customdropdown 
{
    public function toOptionArray()
    {
        return array(
            array('value' =>0, 'label' => Mage::helper('adminhtml')->__('Yes')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('No')),
        );
    }
}
?>