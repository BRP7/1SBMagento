<?php

class Practice_Exam_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_CUSTOM_MESSAGE_1 = 'practice_exam/general/custom_message_1';
    const XML_PATH_CUSTOM_MESSAGE_2 = 'practice_exam/general/custom_message_2';
    const XML_PATH_CUSTOM_MESSAGE_3 = 'practice_exam/general/custom_message_3';

    public function getCustomMessage1()
    {
        return Mage::getStoreConfig(self::XML_PATH_CUSTOM_MESSAGE_1);
    }

    public function getCustomMessage2()
    {
        return Mage::getStoreConfig(self::XML_PATH_CUSTOM_MESSAGE_2);
    }

    public function getCustomMessage3()
    {
        return Mage::getStoreConfig(self::XML_PATH_CUSTOM_MESSAGE_3);
    }
}

