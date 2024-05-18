<?php

class Practice_Jscustomgrid_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice_jscustomgrid/product');
        $this->_addContent($this->getLayout()->createBlock('practice_jscustomgrid/adminhtml_product'));
        $this->renderLayout();
    }
    public function updateCustomAttributeAction()
    {
        $productId = $this->getRequest()->getParam('id');
        $value = $this->getRequest()->getParam('value');

        if ($productId && $value) {
            try {
                $product = Mage::getModel('catalog/product')->load($productId);
                $product->setData('custom_attribute', $value);
                $product->save();

                $response = ['success' => true];
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => $e->getMessage()];
            }
        } else {
            $response = ['success' => false, 'message' => 'Invalid parameters'];
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }

}
