<?php
class Ccc_Filetransfer_Block_Adminhtml_Ftpconfiguration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'configuration_id';
        $this->_controller = 'adminhtml_ftpconfiguration';
        $this->_blockGroup = 'ccc_filetransfer';
        parent::__construct();

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('banner')->__('Save and Continue Edit'),
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
    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('configuration_model')->getId()) {
            return Mage::helper('ccc_filetransfer')->__("Edit Filetransfer '%s'", $this->escapeHtml(Mage::registry('configuration_model')->getTitle()));
        } else {
            return Mage::helper('ccc_filetransfer')->__('New Filetransfer');
        }
    }
}
?>