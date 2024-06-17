<?php
class Ccc_Ticketsystem_Adminhtml_TicketsystemController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ccc_ticketsystem/ticketsystem');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Manage Ticket system'));
        $this->_initAction();
        $this->renderLayout();
    }

}

