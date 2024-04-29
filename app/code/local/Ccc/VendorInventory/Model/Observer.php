<?php

class Ccc_VendorInventory_Model_Observer
{

    public function readcsv()
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'brand');
        // print_r($attribute);

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
        echo "<pre>";
        // print_r($configData);


        $path = Mage::getBaseDir('var') . DS . 'inventory' . DS . $brandId . DS . 'inventory.csv';
        // echo $path;
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
                                print_r($_k);
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
                print_r($temp);
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
