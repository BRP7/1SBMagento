<?php


class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystemview extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/ticket_view_form.phtml');
        // var_dump( $ticket = Mage::registry('ticket_data'));
        // die;
    }

}