<?php

class Ccc_Outlook_Model_Observer{

public function readMail()
    {
        try {
            $emails = Mage::getModel('ccc_outlook/outlook')->getEmails();
            foreach ($emails as $email) {
                print_r($email);
            }
        } catch (Exception $e) {
            Mage::log('Error reading emails: ' . $e->getMessage(), null, 'outlook_emails.log');
        }
    }
}