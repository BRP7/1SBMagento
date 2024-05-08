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
            // print_r($csvProduct);
            foreach ($collection->getData() as $product) {

                if ($csvProduct['sku'] == $product['sku']) {
                    // echo 123;
                    // print ($product['sku']);
                    // // }
                    // $skus[] = $product['sku'];
                    $instockDate = $csvProduct['instock'];
                    var_dump($instockDate);
                    $currentDate = date('d-m-Y');
                    $storedInstockDate = "back order";
                    if ($instockDate == 1) {
                        $storedInstockDate = $currentDate;
                        echo $storedInstockDate;
                        // $product->setData('instock_date', $currentDate);
                        // echo $currentDate;
                    } elseif ($instockDate == 0) {
                        $restockDate = $csvProduct['restock_date'];
                        echo $storedInstockDate;
                        if ($restockDate <= $this->getAheadDate(25, $currentDate)) {
                            $storedInstockDate = $this->getAheadDate(10, $currentDate);
                            echo $storedInstockDate;
                            // echo $this->getAheadDate(10, $currentDate);
                        } elseif($restockDate != null){
                            $storedInstockDate =  $restockDate;
                            // $product->setData('instock_date', $restockDate);
                            // echo $restockDate;
                        }
                    } 
                    $model1 = Mage::getModel('catalog/product')->loadByAttribute('sku', $product['sku']);
                    $model1->setData('instock_date', $storedInstockDate);
                    $model1->getResource()->saveAttribute($model1, 'instock_date');
                    // $product->save();
                    print_r($model1);
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
