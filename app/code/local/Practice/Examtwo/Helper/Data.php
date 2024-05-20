
<?php
class Practice_Examtwo_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_CUSTOM_REPORTS_ENABLED = 'practice_examtwo/settings/enabled';

    public function isCustomReportsEnabled()
    {
        return !Mage::getStoreConfigFlag(self::XML_PATH_CUSTOM_REPORTS_ENABLED);
    }
}
