<?php

class Ccc_Outlook_Model_Attachment extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_outlook/attachment');
    }

    public function setAttachmentData($attachments){
        foreach ($attachments as $attachment) {
            $this->addData(
                [
                    'filename' => $attachment['filename'],
                    'email_id' => $attachment['id'],
                ]
            );
        }
    }
    // public function setAttachment($attachments, $id)
    // {
    //     foreach ($attachments as $attachment) {
    //         $this->addData(
    //             [
    //                 'filename' => $attachment['filename'],
    //                 'email_id' => $id,
    //             ]
    //         )->save();
    //     }
    // }
}
