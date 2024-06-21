<?php

class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystemfilterbutton extends Mage_Adminhtml_Block_Template
{
    public function _construct()
    {
        $this->setTemplate('ticketsystem/ticket_add_filter_button.phtml');
    }

    public function getFilterButton()
    {
        $collection = Mage::getModel('ccc_ticketsystem/filter')->getCollection();
        $collection->getSelect()->distinct(true)->columns('label');
        $distinctValues = $collection->getColumnValues('label');
        $distinctValues = array_unique($distinctValues);
       return $distinctValues;
    }

    public function getButtons()
    {
        $collection = Mage::getModel('ccc_ticketsystem/filter')->getCollection();
        $collection->getSelect()->distinct(true)->reset(Zend_Db_Select::COLUMNS)->columns('label');
        $labels = [];
        foreach ($collection as $item) {
            $labels[] = $item->getLabel();
        }
        return $labels;
    }

}