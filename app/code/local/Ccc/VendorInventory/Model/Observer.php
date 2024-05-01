<?php

class Ccc_VendorInventory_Model_Observer
{

    public function readcsv()
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'brand');
        // print_r($attribute);
        // die;

        if ($attribute && $attribute->getId()) {
            // Load the 'brand' attribute options
            $options = $attribute->getSource()->getAllOptions(false);
            // print_r($options);
            // echo $options->getOptionsId();
            // Print attribute values
            foreach ($options as $option) {
                if ($option['label'] == "CK") {
                    $brandId = $option['value'];
                    // echo $brandId;
                    break;
                }
            }
        }
        $config = Mage::getModel('vendorinventory/vendorinventory')->load($brandId, 'brand_id');
        $brandData = Mage::getModel('vendorinventory/configdata')->load($config->getId(), 'config_id');
        $configData = json_decode($brandData->getBrandData());
        var_dump($configData);
        die;
        echo "<pre>";

        $path = Mage::getBaseDir('var') . DS . 'inventory' . DS . $brandId . DS . 'inventory.csv';
        $row = 0;
        $header = [];
        $array = [];
        if (($open = fopen($path, "r")) !== false) {
            // echo 345;
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                if (!$row) {
                    // echo $row;
                    $header = $data;
                    $row++;
                    continue;
                }
                $array = array_combine($header, $data);
                // print_r($array);
                // print_r($array);
                $temp = [];
                foreach ($configData as $_column => $_config) {
                    $dataColumn = '';
                    // $temp[$_column] = '';
                    $rule = [];
                    foreach ($_config as $_c) {
                        if (!is_string($_c)) {
                            foreach ($_c as $_k => $_v) {
                                // print_r($_k);
                                $dataColumn = $_k;
                                if($_column == 'sku'){
                                    $rule[] = true;
                                    break;
                                }
                                if ($_v->dataValue != '') {
                                    $rule[] = $this->checkRule(
                                        $array[$_k],
                                        $_v->dataValue,
                                        $_v->dataType,
                                        $_v->operator
                                    );
                                } else {
                                    $rule[] = false;
                                }
                            }
                        } else {
                            switch ($_c) {
                                case "AND":
                                    $rule[] = "AND";
                                    break;
                                case "OR":
                                    $rule[] = "OR";
                                    break;
                            }
                        }
                    }
                    // print_r($temp['sku']);

                    $result = false;
                    $logicalOperator = '';
                    foreach ($rule as $item) {
                        if ($item === "AND" || $item === "OR") {
                            $logicalOperator = $item;
                        } else {
                            if ($logicalOperator === "AND") {
                                $result = $result && $item;
                            } else {
                                $result = $result || $item;
                            }
                        }
                    }
                    if ($result)
                        $temp[$_column] = $array[$dataColumn];

                    // $temp['sku'] = $array['part_number'];
                }
                // print_r($temp);
                // $data = Mage::getModel("vendorinventory/items")->getCollection()->addFieldToFilter('brand_id', $brandId)->getFirstItem();
                // if ($data) {
                //     Mage::getModel("vendorinventory/items")->setData($temp)->addData(["brand_id" => $brandId, "brand_items_csv" => $data->getId()])->save();
                // } else {
                //     Mage::getModel("vendorinventory/items")->setData($temp)->addData(["brand_id" => $brandId])->save();
                // }

            }
        }
    }

    public function checkRule($dataValue, $condValue, $condDataType, $condOperator)
    {
        switch (strtolower($condDataType)) {
            case "count":
            case "number":
                return $this->compareValues((int) $dataValue, (int) $condValue, $condOperator);
            case "text":
                return $this->compareValues(strtolower($dataValue), strtolower($condValue), $condOperator);
            case "date":
                $date1 = DateTime::createFromFormat('d-m-Y', $dataValue);
                $date2 = DateTime::createFromFormat('d-m-Y', $condValue);
                return $this->compareValues($date1, $date2, $condOperator);
        }
    }

    public function compareValues($value1, $value2, $operator)
    {
        switch ($operator) {
            case "=":
                return $value1 == $value2;
            case "!=":
                return $value1 != $value2;
            case ">":
                return $value1 > $value2;
            case ">=":
                return $value1 >= $value2;
            case "<":
                return $value1 < $value2;
            case "<=":
                return $value1 <= $value2;
        }
    }
}


// class Ccc_VendorInventory_Model_Observer
// {
//     public function readCsv()
//     {
//         echo "<pre>";
//         $brands = Mage::helper('vendorinventory')->getBrandNames();

//         foreach ($brands as $brandId => $_brandName) {
//             $collection = Mage::getModel('vendorinventory/configdata')
//                 ->getCollection()
//                 ->addFieldtoFilter('vendorinventory.brand_id', $brandId)
//                 ->join('vendorinventory', 'main_table.configuration_id=vendorinventory.configuration_id');
//             $brandConfig = json_decode($collection->getFirstItem()->getBrandData());

//             if (is_null($brandConfig))
//                 continue;

//             $file = fopen(Mage::getBaseDir('var') . DS . 'inventory' . DS . $brandId . DS . 'inventory.csv', 'r');
//             $headers = fgetcsv($file);
//             while ($row = fgetcsv($file)) {
//                 $model = Mage::getModel("vendorinventory/items");
//                 $data = array_combine($headers, $row);
//                 $temp = [];
//                 $temp['brand_id'] = $brandId;
//                 foreach ($brandConfig as $_column => $_config) {
//                     $dataColumn = '';
//                     $temp[$_column] = null;
//                     $rule = [];
//                     foreach ($_config as $_c) {
//                         if (!is_string($_c)) {
//                             foreach ($_c as $_k => $_v) {
//                                 $dataColumn = $_k;
//                                 if ($_column == 'sku') {
//                                     $itemCollection = $model->getCollection()->addFieldtoFilter('sku', $data[$_k]);
//                                     if($itemCollection->getFirstItem()->getId()){
//                                         $model->load($itemCollection->getFirstItem()->getId());
//                                     }
//                                     $rule[] = true;
//                                     break;
//                                 }
//                                 if ($_v->condition_value != '') {
//                                     $rule[] = $this->checkRule(
//                                         $data[$_k],
//                                         $_v->condition_value,
//                                         $_v->data_type,
//                                         $_v->condition_operator
//                                     );
//                                 } else {
//                                     $rule[] = false;
//                                 }
//                             }
//                         } else {
//                             switch ($_c) {
//                                 case "AND":
//                                     $rule[] = "AND";
//                                     break;
//                                 case "OR":
//                                     $rule[] = "OR";
//                                     break;
//                             }
//                         }
//                     }
//                     $result = false;
//                     $logicalOperator = '';
//                     foreach ($rule as $item) {
//                         if ($item === "AND" || $item === "OR") {
//                             $logicalOperator = $item;
//                         } else {
//                             if ($logicalOperator === "AND") {
//                                 $result = $result && $item;
//                             } else {
//                                 $result = $result || $item;
//                             }
//                         }
//                     }
//                     if ($result)
//                         $temp[$_column] = $data[$dataColumn];
//                 }
//                 $model->addData($temp)->save();
//                 print_r($temp);
//             }
//         }
//     }

//     public function checkRule($dataValue, $condValue, $condDataType, $condOperator)
//     {
//         switch (strtolower($condDataType)) {
//             case "count":
//             case "number":
//                 return $this->compareValues((int) $dataValue, (int) $condValue, $condOperator);
//             case "text":
//                 return $this->compareValues(strtolower($dataValue), strtolower($condValue), $condOperator);
//             case "date":
//                 $date1 = DateTime::createFromFormat('m/d/Y', $dataValue);
//                 $date2 = DateTime::createFromFormat('Y-m-d', $condValue);
//                 return $this->compareValues($date1, $date2, $condOperator);
//         }
//     }

//     public function compareValues($value1, $value2, $operator)
//     {
//         switch ($operator) {
//             case "=":
//                 return $value1 == $value2;
//             case "!=":
//                 return $value1 != $value2;
//             case ">":
//                 return $value1 > $value2;
//             case ">=":
//                 return $value1 >= $value2;
//             case "<":
//                 return $value1 < $value2;
//             case "<=":
//                 return $value1 <= $value2;
//         }
//     }
// }
