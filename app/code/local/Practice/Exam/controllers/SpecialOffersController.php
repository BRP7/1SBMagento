<?php
class Practice_Exam_SpecialOffersController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->getBlock('special_offers');
        if ($block) {
            // Get special offers using block method
            $specialOffers = $block->getSpecialOffers();
            $block->setData('special_offers', $specialOffers);
        }
        $this->renderLayout();
    }
}
