<?php

class Practice_Permissionpractice_Block_Adminhtml_Permissionpractice extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_permissionpractice';
        $this->_blockGroup = 'practice_permissionpractice';
        $this->_headerText = $this->__('Manage Custom Grids'); // Updated this line
        parent::__construct();
        if(!Mage::getSingleton('admin/session')->isAllowed('practice_permissionpractice/permissionpractice/new')){
            $this->_removeButton('add');
        }
    }
}
