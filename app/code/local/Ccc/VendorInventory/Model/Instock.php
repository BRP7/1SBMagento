<?php

class Ccc_VendorInventory_Model_Instock
{
    public function instockProcess()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku');
        $model = Mage::getModel("vendorinventory/items")->getCollection();
        foreach ($model->getData() as $csvProduct) {
            print_r($csvProduct);
            foreach ($collection->getData() as $product) {

                if ($csvProduct['sku'] == $product['sku']) {
                    $instockDate = $csvProduct['instock'];
                    var_dump($instockDate);
                    $currentDate = date('d-m-Y');
                    $storedInstockDate;
                    // if ($instockDate == 1) {
                    //     $storedInstockDate = $currentDate;
                    //     echo $storedInstockDate;
                    //     // $product->setData('instock_date', $currentDate);
                    //     // echo $currentDate;
                    // } elseif ($instockDate == 0) {
                    //     $restockDate = $csvProduct['restock_date'];
                    //     echo $storedInstockDate;
                    //     if ($restockDate <= $this->getAheadDate(25, $currentDate)) {
                    //         $storedInstockDate = $this->getAheadDate(10, $currentDate);
                    //         echo $storedInstockDate;
                    //         // echo $this->getAheadDate(10, $currentDate);
                    //     } elseif($restockDate != null){
                    //         $storedInstockDate =  $restockDate;
                    //         // $product->setData('instock_date', $restockDate);
                    //         // echo $restockDate;
                    //     }
                    // } 


                    // Assuming $instockDate, $currentDate, and $csvProduct['restock_date'] are defined earlier

                    switch ($instockDate) {
                        case 1:
                            $storedInstockDate = $this->getAheadDate(2, $currentDate);
                            break;

                        case 0:
                            $restockDate = $csvProduct['restock_date'];
                            if ($restockDate <= $this->getAheadDate(25, $currentDate) && $restockDate !== null ) {
                                $storedInstockDate = $this->getAheadDate(10, $currentDate);
                            } elseif ($restockDate > $this->getAheadDate(25, $currentDate) && $restockDate !== null) {
                                $storedInstockDate = $restockDate;
                            } else{
                                $storedInstockDate = "back order";
                            }
                            break;

                        default:
                            echo 123;
                            $storedInstockDate = "back order";
                            break;
                    }

                    // $model1 = Mage::getModel('catalog/product')->loadByAttribute('sku', $product['sku']);
                    // $model1->setData('instock_date', $storedInstockDate);
                    // $model1->getResource()->saveAttribute($model1, 'instock_date');

                    $model1 = Mage::getModel('catalog/product')->loadByAttribute('sku', $product['sku']);
                    $model1->setData('instock_date', $storedInstockDate);
                    $model1->getResource()->saveAttribute($model1, 'instock_date');
                    // $product->save();
                    // print_r($model1);
                }
            }
        }
        // print_r($skus);
    }

    public function getAheadDate($aheadDay, $startingDate)
    {
        return date('d-m-Y', strtotime('+' . $aheadDay . ' days', strtotime($startingDate)));
    }
}
