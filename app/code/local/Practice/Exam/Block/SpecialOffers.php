<?php
class Practice_Exam_Block_SpecialOffers extends Mage_Core_Block_Template
{
   
        public function getSpecialOffersProducts()
        {
            // echo 111111111111111;
            // Fetch special offer products collection
            $specialOffers = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('special_price', array('gt' => 0));
    
            return $specialOffers; // This should be an array or a collection object
        }
    
    
}
