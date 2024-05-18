<?php

require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';

class Practice_Exam_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{

    public function indexAction()
    {
        parent::indexAction();
        // // Logic to save product data
        // $productId = $this->getRequest()->getParam('id');
        $productId = 400;
        $product = Mage::getModel('catalog/product')->load($productId);
        $product->setName($this->getRequest()->getParam('name'));
        // // Set other product attributes as needed
        // $product->save();

        // Dispatch custom event
        Mage::dispatchEvent('custom_event', array('product' => $product));

        // Redirect or return response
        // $this->_redirect('*/*/index');
    }

}