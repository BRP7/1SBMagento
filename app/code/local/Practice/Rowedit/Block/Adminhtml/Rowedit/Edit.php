<?php 

class Practice_Rowedit_Block_Adminhtml_Rowedit_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'entity_id';
        $this->_controller = 'adminhtml_rowedit';
        $this->_blockGroup = 'practice_rowedit';
        parent::__construct();
        
        $this->_updateButton('save', 'label', Mage::helper('practice_rowedit')->__('Save Row'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_rowedit')->__('Delete Row'));
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
        $this->_formScripts[] = "
        function toggleEditor() {
            if (tinyMCE.getInstanceById('jalebi_content') == null) {
                tinyMCE.execCommand('mceAddControl', false, 'row_content');
            } else {
                tinyMCE.execCommand('mceRemoveControl', false, 'row_content');
            }
        }
        
        function saveAndContinueEdit(){
            editForm.submit($('edit_form').action+'back/edit/');
        }
        ";
    }
}

?>