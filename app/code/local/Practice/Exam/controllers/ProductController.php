<?php

class Practice_Exam_ProductController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function ajaxUpdateAction()
    {
        $productId = $this->getRequest()->getParam('product_id');
        $customAttribute = $this->getRequest()->getParam('custom_attribute');

        $product = Mage::getModel('catalog/product')->load($productId);
        if ($product->getId()) {
            try {
                $product->setCustomAttribute($customAttribute);
                $product->save();
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['success' => true]));
            } catch (Exception $e) {
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['error' => $e->getMessage()]));
            }
        } else {
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['error' => 'Product not found.']));
        }
    }
}



