<?php
class Practice_Rowedit_Block_Adminhtml_Rowedit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_rowedit';
        $this->_blockGroup = 'practice_rowedit';
        $this->_headerText = Mage::helper('practice_rowedit')->__('Rowedit');
        parent::__construct();        
    }
}
