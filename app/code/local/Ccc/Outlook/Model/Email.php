<?php

class Ccc_Outlook_Model_Email extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_outlook/email');
    }
    protected function setMail($mails)
    {
        foreach ($mails as $mail) {
            $id=$this->addData(
                [
                    'subject' => $mail['subject'],
                    'from' => $mail['from'],
                    'to' => $mail['to'],
                    'body' => $mail['body']
                ]
            )->save();
            if ($mail['attachment']) {
                Mage::getModel('ccc_outlook/attachment')
                    ->setAttachment($mail['attachment'],$id);
            }
        }
    }
}
