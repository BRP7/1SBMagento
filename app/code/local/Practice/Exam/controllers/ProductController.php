<?php

class Practice_Exam_ProductController extends Mage_Core_Controller_Front_Action
{
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

