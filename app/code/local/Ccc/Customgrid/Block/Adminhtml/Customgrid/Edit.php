<?php
class Practice_Customgrid_Block_Adminhtml_Customgrid_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {

        $this->_objectId = 'id';
        $this->_blockGroup = 'practice_customgrid';
        $this->_controller = 'adminhtml_customgrid';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('practice_customgrid')->__('Save Customgrid'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_customgrid')->__('Delete Customgrid'));
        //$this->_updateButton('delete', 'label', Mage::helper('practice_customgrid')->__('Delete Customgrid'));
        if(!Mage::getSingleton('admin/session')->isAllowed('practice_customgrid/customgrid/delete')){
            $this->removeButton('delete');
            }

        // $this->_addButton('delete', array(
        //     'label' => Mage::helper('practice_customgrid')->__('Delete Customgrid'),
        //     'onclick' => "setLocation('".$this->getUrl('*/*/delete',array('customgrid_id' => $this->getId()))."')",
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
        $model = Mage::registry('customgrid_data');
        if ($model && $model->getId()) {
            return Mage::helper('practice_customgrid')->__('Edit Customgrid');
        } else {
            return Mage::helper('practice_customgrid')->__('New Customgrid');
        }
    }
}
