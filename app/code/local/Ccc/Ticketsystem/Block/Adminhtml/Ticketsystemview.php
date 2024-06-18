<?php


class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystemview extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/ticket_view_form.phtml');
        // var_dump( $ticket = Mage::registry('ticket_data'));
        // die;
    }

    public function getTicket()
    {
        $id = $this->getRequest()->getParam('id');
        return Mage::getModel('ccc_ticketsystem/ticketsystem')->load($id);
    }
    public function getStatus($statusId)
    {
        return Mage::getModel('ccc_ticketsystem/status')->load($statusId);
       
    }

}