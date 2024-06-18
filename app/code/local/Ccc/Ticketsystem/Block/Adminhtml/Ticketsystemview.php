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

    public function getUsers()
    {
        $users = Mage::getResourceModel('admin/user_collection')
            ->addFieldToSelect(['user_id', 'username'])
            ->addFieldToFilter('is_active', 1)
            ->setOrder('username', 'ASC');

        foreach ($users as $user) {
            $usersArray[$user->getUserId()] = $user->getUsername();
        }
        return $usersArray;
    }

    public function getStatusOptions()
    {
        $statuses = Mage::getResourceModel('ccc_ticketsystem/status_collection')
            ->addFieldToSelect(['status_id', 'label']); 

        $options = [];
        foreach ($statuses as $status) {
            var_dump($status->getId());
            $options[$status->getId()] = $status->getLabel();
        }
        return $options;
    }
}