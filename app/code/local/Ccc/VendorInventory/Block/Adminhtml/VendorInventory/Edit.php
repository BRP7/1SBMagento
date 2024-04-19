<?php
class Ccc_VendorInventory_Block_Adminhtml_VendorInventory_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_vendorinventory';
        $this->_blockGroup = 'ccc_vendorinventory'; // Corrected block group name

        parent::__construct();

        
        // $this->_updateButton('save', 'label', Mage::helper('vendorinventory')->__('Save Inventory'));
        // $this->_updateButton('delete', 'label', Mage::helper('vendorinventory')->__('Delete Inventory'));
        // if(!Mage::getSingleton('admin/session')->isAllowed('ccc_vendorinventory/delete')){
        // $this->removeButton('delete');
        // }


        // $this->_addButton('saveandcontinue', array(
        //     'label'     => Mage::helper('vendorinventory')->__('Save and Continue Edit'),
        //     'onclick'   => 'saveAndContinueEdit()',
        //     'class'     => 'save',
        // ), -100);

        // $this->_formScripts[] = "
        //     function toggleEditor() {
        //         if (tinyMCE.getInstanceById('block_content') == null) {
        //             tinyMCE.execCommand('mceAddControl', false, 'block_content');
        //         } else {
        //             tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
        //         }
        //     }

        //     function saveAndContinueEdit(){
        //         editForm.submit($('edit_form').action+'back/edit/');
        //     }
        // ";
    }

    // public function getHeaderText()
    // {
    //     if (Mage::registry('vendorinventory_block')->getId()) {
    //         return Mage::helper('vendorinventory')->__('Edit vendorinventory');
    //     } else {
    //         return Mage::helper('vendorinventory')->__('New vendorinventory');
    //     }
    // }

    // public function getFormHtml()
    // {
    //     $form = $this->getChild('form');
    //     if ($form instanceof Mage_Core_Block_Abstract) {
    //         return $form->toHtml();
    //     } else {
    //         return ''; // Return empty string if form block is not found
    //     }
    // }


        // protected function _prepareLayout()
    // {
    //     parent::_prepareLayout();

    //     // Update button labels and remove duplicate button declaration if necessary

    //     $this->_updateButton('save', 'label', Mage::helper('banner')->__('Save Banner'));
    //     $this->_updateButton('delete', 'label', Mage::helper('banner')->__('Delete Banner'));

    //     return $this;
    // }
    
}
