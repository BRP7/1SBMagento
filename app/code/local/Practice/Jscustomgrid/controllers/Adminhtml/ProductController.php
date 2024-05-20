<?php

class Practice_Jscustomgrid_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice_jscustomgrid/product');
        
        // $block = $this->getLayout()->createBlock('practice_jscustomgrid/adminhtml_product');

        // if (!$block) {
        //     echo 11231;
        //     Mage::log('Failed to create block: practice_jscustomgrid/adminhtml_product', null, 'custom.log');
        // }
        
        // $this->_addContent($block);
        $this->renderLayout();
    }

    protected function _validateFormKey()
    {
        return true;
    }

    public function updateCustomAttributeAction()
    {
        $response = array('success' => false);

        if ($data = $this->getRequest()->getPost()) {
            $productId = $data['id'];
            $value = $data['value'];

            try {
                $product = Mage::getModel('catalog/product')->load($productId);
                $product->setData('custom_select_attribute', $value); // Replace 'custom_select_attribute' with your attribute code
                $product->save();

                $response['success'] = true;
            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }

    public function getProductDetailsAction()
    {
        $productId = $this->getRequest()->getParam('id');

        if ($productId) {
            $product = Mage::getModel('catalog/product')->load($productId);
            $response = [
                'name' => $product->getName(),
                'custom_select_attribute' => $product->getData('custom_select_attribute'),
                'color'=> $product->getColor(),
                'brand'=>$product->getBrand(),
                'price'=>$product->getPrice(),
            ];
        } else {
            $response = ['error' => 'Product not found'];
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}
