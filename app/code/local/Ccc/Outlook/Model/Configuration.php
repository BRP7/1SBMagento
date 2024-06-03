<?php
class Ccc_Outlook_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'last_stored_email';
    protected $_eventObject = 'email';
    protected function _construct()
    {
        $this->_init('ccc_outlook/configuration');
    }

    public function formatDates($dateString)
    {
        $date = new DateTime($dateString, new DateTimeZone('UTC'));
        return $date->format('Y-m-d H:i:s');
    }

    public function fetchEmails()
    {
        $apiModel = Mage::getModel('ccc_outlook/outlook')->setConfigurationData($this);
        $emails = $apiModel->getEmails();
        foreach ($emails as $email) {
            $emailModel = Mage::getModel("ccc_outlook/email");
           $emailModel->setConfigurationObject($this)
                ->setRowData($email)
                ->save();
        }
        var_dump($email['has_attachments']);
        if($email['has_attachments']){
           $emailModel->fetchAndSaveAttachment();
        }
    }
}
