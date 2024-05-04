<?php

class Ccc_VendorInventory_Model_Instock
{
    public function instockProcess()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku');
        $model = Mage::getModel("vendorinventory/items")->getCollection();
        $skus = array();
        foreach ($model->getData() as $csvProduct) {
            print_r($csvProduct);
            foreach ($collection as $product) {

                if ($csvProduct['sku'] == $product->getSku()) {
                    // echo 123;
                    // print($product->getSku());
                }
                //         $skus[] = $product->getSku();
                //         $instockDate = $csvProduct->getInstock();
                //         $currentDate = date('d-m-Y');
                //         if ($instockDate == 1) {
                //             $product->setData('instock_date', $currentDate);
                //         } elseif ($instockDate == 0) {
                //             $restockDate = $csvProduct->getRestockDate();
                //             if ($restockDate <= $this->getAheadDate(25,$currentDate)) {
                //                 $product->setData('instock_date', $this->getAheadDate(10,$currentDate));
                //             } else {
                //                 $product->setData('instock_date', $restockDate);
                //             }
                //         } elseif ($instockDate == null) {
                //             $product->setData('instock_date', null);
                //         }
                //         $product->save();
                //     }
            }
        }
        print_r($skus);
    }

    public function getAheadDate($aheadDay, $startingDate)
    {
        return date('d-m-Y', strtotime('+' . $aheadDay . ' days', strtotime($startingDate)));
    }
}
