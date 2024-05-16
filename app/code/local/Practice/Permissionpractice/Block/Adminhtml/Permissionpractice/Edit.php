<?php
class Practice_Permissionpractice_Block_Adminhtml_Permissionpractice_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {

        $this->_objectId = 'id';
        $this->_blockGroup = 'practice_permissionpractice';
        $this->_controller = 'adminhtml_permissionpractice';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('practice_permissionpractice')->__('Save Permissionpractice'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_permissionpractice')->__('Delete Permissionpractice'));
        //$this->_updateButton('delete', 'label', Mage::helper('practice_permissionpractice')->__('Delete Permissionpractice'));
        if(!Mage::getSingleton('admin/session')->isAllowed('practice_permissionpractice/permissionpractice/delete')){
            $this->removeButton('delete');
            }

        // $this->_addButton('delete', array(
        //     'label' => Mage::helper('practice_permissionpractice')->__('Delete Permissionpractice'),
        //     'onclick' => "setLocation('".$this->getUrl('*/*/delete',array('permissionpractice_id' => $this->getId()))."')",
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
        $model = Mage::registry('permissionpractice_data');
        if ($model && $model->getId()) {
            return Mage::helper('practice_permissionpractice')->__('Edit Permissionpractice');
        } else {
            return Mage::helper('practice_permissionpractice')->__('New Permissionpractice');
        }
    }
}
