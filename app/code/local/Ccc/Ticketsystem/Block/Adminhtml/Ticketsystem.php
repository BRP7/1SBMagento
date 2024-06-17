<?php


class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystem extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/ticket_edit_form.phtml');
    }

    public function getTicketCollection()
    {
        $collection = Mage::getModel('ccc_ticketsystem/ticketsystem')->getCollection();
        return $collection;
    }

    public function getStatusColor($statusId)
    {
        return Mage::getModel('ccc_ticketsystem/status')
            ->load($statusId)
            ->getColorCode();
    }
}