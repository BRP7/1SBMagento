<?php
class Practice_Reportmanager_Block_Adminhtml_Reportmanager_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_reportmanager';
        $this->_blockGroup = 'practice_reportmanager';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('practice_reportmanager')->__('Save reportmanager'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_reportmanager')->__('Delete reportmanager'));
        if (!Mage::getSingleton('admin/session')->isAllowed('practice_reportmanager/delete')) {
            $this->removeButton('delete');
        }

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('practice_reportmanager')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
        function toggleEditor() {
            if (tinyMCE.getInstanceById('block_content') == null) {
                tinyMCE.execCommand('mceAddControl', false, 'block_content');
            } else {
                tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
            }
        }

        function saveAndContinueEdit(){
            editForm.submit($('edit_form').action+'back/edit/');
        }
    ";
    }
    
    public function getHeaderText()
    {
        if (Mage::registry('reportmanager_block')->getId()) {
            return Mage::helper('practice_reportmanager')->__("Edit reportmanager '%s'", $this->escapeHtml(Mage::registry('reportmanager_block')->getTitle()));
        } else {
            return Mage::helper('practice_reportmanager')->__('New Reportmanager');
        }
    }
}
?>