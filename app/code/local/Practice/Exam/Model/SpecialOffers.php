<?php
class Practice_Exam_Model_SpecialOffers
{
    // Example: Method to fetch special offers collection
    public function getCollection()
    {
        // Fetch and return special offers collection
        $collection = Mage::getModel('practice_exam/specialOffers')->getCollection();
        return $collection;
    }
}
