<?php
class Practice_Examtwo_Model_Observer
{
    const XML_PATH_CUSTOM_REPORTS_ENABLED = 'practice_examtwo/settings/enabled';
    const XML_PATH_MODULES_DISABLE_OUTPUT = 'advanced/modules_disable_output/Practice_Examtwo';

    public function configChanged(Varien_Event_Observer $observer)
    {
        $enabled = Mage::getStoreConfigFlag(self::XML_PATH_CUSTOM_REPORTS_ENABLED);
        Mage::getConfig()->saveConfig(self::XML_PATH_MODULES_DISABLE_OUTPUT, $enabled ? true : false);
        Mage::app()->getCacheInstance()->cleanType('config');
    }

    public function coreConfigChanged(Varien_Event_Observer $observer)
    {
        $isModuleDisabled = Mage::getStoreConfigFlag(self::XML_PATH_MODULES_DISABLE_OUTPUT);
        Mage::getConfig()->saveConfig(self::XML_PATH_CUSTOM_REPORTS_ENABLED, $isModuleDisabled ? true : false);
        Mage::app()->getCacheInstance()->cleanType('config');
    }
}
