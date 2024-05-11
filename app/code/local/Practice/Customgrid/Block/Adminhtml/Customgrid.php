<?php

class Practice_Customgrid_Block_Adminhtml_Customgrid extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct(){
        $this->_controller = 'adminhtml_customgrid';
        $this->_blockGroup = 'customgrid';
        $this->_headerText = Mage::helper('customgrid')->__('Manage Custom Grids');
        parent::__construct();
    }
}