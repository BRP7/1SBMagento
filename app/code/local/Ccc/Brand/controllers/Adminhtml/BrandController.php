<?php
class Ccc_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('brand_attributes');
        $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand'));
        $this->renderLayout();
    }
    

    // public function editAction()
    // {
    //     $brandId = $this->getRequest()->getParam('id');
    //     $brand = Mage::getModel('eav/entity_attribute_option')->load($brandId);

    //     if (!$brand->getId()) {
    //         Mage::getSingleton('adminhtml/session')->addError('Brand option does not exist.');
    //         $this->_redirect('*/*/');
    //         return;
    //     }

    //     Mage::register('current_brand', $brand);

    //     $this->loadLayout();
    //     $this->_setActiveMenu('brand_attributes');
    //     $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand_edit'));
    //     $this->renderLayout();
    // }



    public function editAction()
{
    $optionId = $this->getRequest()->getParam('option_id'); // Corrected to option_id
    $brand = Mage::getModel('eav/entity_attribute_option')->load($optionId);

    if (!$brand->getId()) {
        Mage::getSingleton('adminhtml/session')->addError('Brand option does not exist.');
        $this->_redirect('*/*/index');
        return;
    }

    Mage::register('current_brand', $brand);

    $this->loadLayout();
    $this->_setActiveMenu('brand_attributes');
    $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand_edit'));
    $this->renderLayout();
}

    public function newAction()
    {
        $this->editAction();
    }

    // public function saveAction()
    // {
    //     if ($data = $this->getRequest()->getPost()) {
    //         try {
    //             if (!empty($data['id'])) {
    //                 $optionId = $data['id'];
    //                 $brand = Mage::getModel('eav/entity_attribute_option')->load($optionId);
    //             } else {
    //                 $brand = Mage::getModel('eav/entity_attribute_option');
    //             }
    
    //             // Ensure that the attribute_id is set properly
    //             $attributeId = 216; // Assuming 216 is the ID of the brand attribute
    //             $brand->setAttributeId($attributeId);
    
    //             $brand->setData('value', $data['value'])->save();
    //             Mage::getSingleton('adminhtml/session')->addSuccess('Brand option has been saved.');
    
    //             // Redirect back to the grid
    //             $this->_redirect('*/*/index');
    //             return;
    //         } catch (Exception $e) {
    //             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    //         }
    //     }
    
    //     // If there was an error or if the data was not properly saved, redirect back to the edit page
    //     $this->_redirectReferer();
    // }
    
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                if (!empty($data['id'])) {
                    $optionId = $data['id'];
                    $brand = Mage::getModel('eav/entity_attribute_option')->load($optionId);
                } else {
                    $brand = Mage::getModel('eav/entity_attribute_option');
                }
    
                // Ensure that the attribute_id is set properly
                $attributeId = 216; // Assuming 216 is the ID of the brand attribute
                $brand->setAttributeId($attributeId);
    
                $brand->setData('value', $data['value'])->save();
                Mage::getSingleton('adminhtml/session')->addSuccess('Brand option has been saved.');
    
                // Redirect back to the grid
                $this->_redirect('*/*/index');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    
        // If there was an error or if the data was not properly saved, redirect back to the edit page
        $this->_redirectReferer();
    }
    

protected function _refreshCollection()
{
    // Get the grid block and refresh its collection
    $block = $this->getLayout()->getBlock('brand_grid');
    if ($block) {
        $block->getCollection()->clear();
        $block->getCollection()->load();
    }
}

    
    public function editOptionAction()
    {
        $optionId = $this->getRequest()->getParam('option_id');
        $this->_forward('edit', null, null, array('id' => $optionId));
    }
}
