<?php

class Practice_Exam_Block_Adminhtml_Exam extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_exam';
        $this->_blockGroup = 'practice_exam';
        $this->_headerText = $this->__('Manage Custom Grids'); // Updated this line
        parent::__construct();
        if(!Mage::getSingleton('admin/session')->isAllowed('practice_exam/exam/new')){
            $this->_removeButton('add');
        }
    }

}
