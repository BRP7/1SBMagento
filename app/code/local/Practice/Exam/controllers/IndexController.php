<?php

class Practice_Exam_IndexController extends Mage_Core_Controller_Front_Action
{
    // public function indexAction()
    // {
    //     // Fetch custom messages from configuration
    //     $message1 = Mage::helper('practice_permissionpractice')->getCustomMessage1();
    //     $message2 = Mage::helper('practice_permissionpractice')->getCustomMessage2();
    //     $message3 = Mage::helper('practice_permissionpractice')->getCustomMessage3();

    //     echo "Message 1: " . $message1 . "<br>";
    //     echo "Message 2: " . $message2 . "<br>";
    //     echo "Message 3: " . $message3 . "<br>";

    //     // Fetch and display category name
    //     $categoryId = 4; // Example category ID
    //     $category = Mage::getModel('catalog/category')->load($categoryId);
    //     if ($category->getId()) {
    //         echo "Category Name: " . $category->getName() . "<br>";
    //     } else {
    //         echo "Category not found.<br>";
    //     }

    //     // Fetch and display product attributes
    //     $productId = 905;
    //     $product = Mage::getModel('catalog/product')->load($productId);
    //     if ($product->getId()) {
    //         $attributes = $product->getAttributes();
    //         foreach ($attributes as $attribute) {
    //             $attributeCode = $attribute->getAttributeCode();
    //             $attributeValue = $product->getData($attributeCode);
    //             echo "<strong>$attributeCode:</strong> ";
                
    //             if (is_array($attributeValue)) {
    //                 // Handle array attributes
    //                 if ($attributeCode == 'media_gallery') {
    //                     // Special handling for media_gallery attribute
    //                     foreach ($attributeValue['images'] as $image) {
    //                         echo 'Image: ' . $image['file'] . '<br>';
    //                     }
    //                 } else {
    //                     echo implode(', ', $attributeValue);
    //                 }
    //             } elseif (is_object($attributeValue)) {
    //                 // Handle object attributes
    //                 if ($attributeValue instanceof Mage_Eav_Model_Entity_Attribute_Abstract) {
    //                     echo $attributeValue->getFrontend()->getValue($product);
    //                 } else {
    //                     echo (string)$attributeValue;
    //                 }
    //             } else {
    //                 // Handle other types
    //                 echo (string)$attributeValue;
    //             }
                
    //             echo "<br>";
    //         }
    //     } else {
    //         echo "Product not found.<br>";
    //     }

    //     // Fetch category names from path
    //     $path = '1/2/4/12';
    //     $categoryIds = explode('/', $path);

    //     foreach ($categoryIds as $categoryId) {
    //         $category = Mage::getModel('catalog/category')->load($categoryId);
    //         if ($category->getId()) {
    //             echo $category->getName() . ' > ';
    //         } else {
    //             echo "Category ID $categoryId not found > ";
    //         }
    //     }
    // }


    public function indexAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->getBlock('special.offers');
        if ($block) {
            // Get special offers using block method
            $specialOffers = $block->getSpecialOffersProducts();
            $block->setData('special_offers', $specialOffers);
        }
        $this->renderLayout();
    }


}
