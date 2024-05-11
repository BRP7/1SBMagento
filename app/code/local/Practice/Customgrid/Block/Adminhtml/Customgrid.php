<?php

class Practice_Customgrid_Block_Adminhtml_Customgrid extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_customgrid';
        $this->_blockGroup = 'practice_customgrid';
        $this->_headerText = $this->__('Manage Custom Grids'); // Updated this line
        parent::__construct();
    }
}
