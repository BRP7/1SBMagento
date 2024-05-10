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

    public function editAction()
    {
        $brandId = $this->getRequest()->getParam('id');
        $brand = Mage::getModel('eav/entity_attribute_option')->load($brandId);

        if (!$brand->getId()) {
            Mage::getSingleton('adminhtml/session')->addError('Brand option does not exist.');
            $this->_redirect('*/*/');
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

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                if (!empty($data['id'])) {
                    $brand = Mage::getModel('eav/entity_attribute_option')->load($data['id']);
                } else {
                    $brand = Mage::getModel('eav/entity_attribute_option');
                }
                $brand->setData('value', $data['value'])->save();
                Mage::getSingleton('adminhtml/session')->addSuccess('Brand option has been saved.');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/');
    }
}
