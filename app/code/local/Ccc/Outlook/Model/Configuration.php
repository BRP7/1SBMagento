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
        $failedEmails = $this->processEmails($emails);

        if (!empty($failedEmails)) {
            $this->processEmails($failedEmails, true);
        }
    }
 

    //isRetry is used for to identify weather error occurred during process email or retry email
    protected function processEmails($emails, $isRetry = false)
    {
        $failedEmails = [];
        foreach ($emails as $email) {
            try {
                $emailModel = Mage::getModel("ccc_outlook/email");
                $emailModel->setConfigurationObject($this)
                    ->setRowData($email)
                    ->save();

                if ($email['has_attachments']) {
                    $emailModel->fetchAndSaveAttachment();
                }
                $this->setLastReadedEmails($this->formatDates($email['createdDateTime']))->save();
            } catch (Exception $e) {
                Mage::log(($isRetry ? 'Error retrying email: ' : 'Error processing email: ') . $e->getMessage(), null, 'outlook_emails.log');
                $failedEmails[] = $email;
            }
        }
        return $failedEmails;
    }

    public function checkCondition($emailModel)
    {
        $dispatchConfigurations = Mage::getModel('ccc_outlook/dispatchevent')
            ->getCollection()
            ->addFieldToFilter("configuration_id", $this->getId());

        $groupedConfigurations = [];
        foreach ($dispatchConfigurations as $config) {
            $groupedConfigurations[$config->getGroupId()][] = $config;
        }

        foreach ($groupedConfigurations as $groupId => $configs) {
            $flag = true;

            foreach ($configs as $config) {
                $flag = $this->matchCondition($emailModel, $config, $flag);

                if (!$flag) {
                    break;
                }
            }

            if ($flag) {
                echo "event called!";
                var_dump($configs[0]->getEvent());
                Mage::dispatchEvent($configs[0]->getEvent());
            }
        }
    }

    public function matchCondition($emailModel, $config, $flag)
    {
        switch ($config->getOperator()) {
            case '=':
                $result = $emailModel[$config->getConditionName()] == $config->getValue();
                break;
            case '>=':
                $result = strcmp($emailModel[$config->getConditionName()], $config->getValue()) >= 0;
                break;
            case '<=':
                $result = strcmp($emailModel[$config->getConditionName()], $config->getValue()) <= 0;
                break;
            case '!=':
                $result = $emailModel[$config->getConditionName()] != $config->getValue();
                break;
            case 'Like':
                $result = strpos($emailModel[$config->getConditionName()], $config->getValue()) !== false;
                break;
            case '%Like%':
                $result = strpos($emailModel[$config->getConditionName()], $config->getValue()) !== false;
                break;
            default:
                $result = false;
                break;
        }
        return $flag && $result;
    }
}
