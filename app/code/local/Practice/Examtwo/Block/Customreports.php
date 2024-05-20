<?php
class Practice_Examtwo_Block_Customreports extends Mage_Core_Block_Template
{
    public function __construct()
    {
        echo 1111;
        // parent::__construct();
        // $this->setTemplate('examtwo/custom_reports.phtml');
    }
    protected function _toHtml()
    {
        // echo 3322;
        if (!Mage::helper('practice_examtwo')->isCustomReportsEnabled()) {
            return 'ytytyrtry';
        }

        return parent::_toHtml();
    }
}
