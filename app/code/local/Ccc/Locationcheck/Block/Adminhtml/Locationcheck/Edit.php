<?php
class Ccc_Locationcheck_Block_Adminhtml_Locationcheck_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_locationcheck';
        $this->_blockGroup = 'ccc_locationcheck';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('locationcheck')->__('Save locationcheck'));
        $this->_updateButton('delete', 'label', Mage::helper('locationcheck')->__('Delete locationcheck'));
        if (!Mage::getSingleton('admin/session')->isAllowed('ccc_locationcheck/delete')) {
            $this->removeButton('delete');
        }

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('locationcheck')->__('Save and Continue Edit'),
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
        if (Mage::registry('locationcheck_block')->getId()) {
            return Mage::helper('locationcheck')->__("Edit locationcheck '%s'", $this->escapeHtml(Mage::registry('locationcheck_block')->getTitle()));
        } else {
            return Mage::helper('locationcheck')->__('New Locationcheck');
        }
    }
}
?>