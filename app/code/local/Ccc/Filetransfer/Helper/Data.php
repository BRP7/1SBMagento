<?php
class Ccc_Filetransfer_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getFileUrl()
    {
        return Mage::getBaseDir() . DS . 'var' . DS . 'FileZilla' ;
    }
    public function getXmlData()
    {
        return array(
            'part_number' => 'item.itemIdentification.itemIdentifier:itemNumber',
        );

    }
}