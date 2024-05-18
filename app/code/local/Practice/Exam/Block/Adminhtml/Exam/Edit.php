<?php
class Practice_Exam_Block_Adminhtml_Exam_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {

        $this->_objectId = 'id';
        $this->_blockGroup = 'practice_exam';
        $this->_controller = 'adminhtml_exam';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('practice_exam')->__('Save Exam'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_exam')->__('Delete Exam'));
        //$this->_updateButton('delete', 'label', Mage::helper('practice_exam')->__('Delete Exam'));
        if(!Mage::getSingleton('admin/session')->isAllowed('practice_exam/exam/delete')){
            $this->removeButton('delete');
            }

        // $this->_addButton('delete', array(
        //     'label' => Mage::helper('practice_exam')->__('Delete Exam'),
        //     'onclick' => "setLocation('".$this->getUrl('*/*/delete',array('exam_id' => $this->getId()))."')",
        //     'class' => 'save',
        // ), -100);

        // $this->_formScripts[] = "
        //     function saveAndContinueEdit(){
        //         editForm.submit($('edit_form').action+'back/edit/');
        //     }
        // ";
    }

    public function getHeaderText()
    {
        $model = Mage::registry('exam_data');
        if ($model && $model->getId()) {
            return Mage::helper('practice_exam')->__('Edit Exam');
        } else {
            return Mage::helper('practice_exam')->__('New Exam');
        }
    }
}
