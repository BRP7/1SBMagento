<?php

class Ccc_VendorInventory_Model_Observer
{
    public function readCsv()
    {
    
        $brands = Mage::helper('vendorinventory')->getBrandNames();

        foreach ($brands as $brandId => $_brandName) {
           
            if ($_brandName['label'] != 'CK') {
                continue;
            }

            $brandId = $_brandName['value'];


            $collection = Mage::getModel('vendorinventory/configdata')
                ->getCollection()
                ->addFieldtoFilter('vendorinventory.brand_id', $brandId)
                ->join('vendorinventory', 'main_table.id=vendorinventory.config_id');
            $brandConfig = json_decode($collection->getFirstItem()->getBrandData());

            if (is_null($brandConfig)){
                // echo "Brand configuration not found for brand ID: $brandId\n";
                continue;
            }
            // echo "Brand configuration found: " . print_r($brandConfig, true) . "\n";


            $file = fopen(Mage::getBaseDir('var') . DS . 'inventory' . DS . $brandId . DS . 'inventory.csv', 'r');
    
            $headers = fgetcsv($file);
            while ($row = fgetcsv($file)) {
                $model = Mage::getModel("vendorinventory/items");
                $data = array_combine($headers, $row);
                $temp = [];
                $temp['brand_id'] = $brandId;
                foreach ($brandConfig as $_column => $_config) {
                    $dataColumn = '';
                    $temp[$_column] = null;
                    $rule = [];
                    foreach ($_config as $_c) {
                        if (!is_string($_c)) {
                            foreach ($_c as $_k => $_v) { 
                                $dataColumn = $_k;
                                if ($_column == 'sku') {
                                    $itemCollection = $model->getCollection()->addFieldtoFilter('sku', $data[$_k]);
                                    if($itemCollection->getFirstItem()->getId()){
                                        $model->load($itemCollection->getFirstItem()->getId());
                                    }
                                    $rule[] = true;
                                    break;
                                }
                                if ($_v->dataValue != '') {
                                    $rule[] = $this->checkRule(
                                        $data[$_k],
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
                    if ($result){
                        // print_r($_column  ."  ---  " . $data[$dataColumn]);
                        // echo "    ";
                        $temp[$_column] = $data[$dataColumn];
                    }else{
                        echo 121;
                        $temp[$_column] = " ";
                        // print($temp[$_column]);
                    }
                }
                // echo "Temporary data array: " . print_r($temp, true) . "\n";
                $model->addData($temp)->save();
                // var_dump($temp);
            }
        } 
    }

    public function checkRule($dataValue, $condValue, $condDataType, $condOperator)
    {
        // echo 123;
        switch (strtolower($condDataType)) {
            case "count":
            case "number":
                // echo 123;
                // print_r($this->compareValues((int) $dataValue, (int) $condValue, $condOperator));
                return $this->compareValues((int) $dataValue, (int) $condValue, $condOperator);
            case "text":
                // print_r($this->compareValues(strtolower($dataValue), strtolower($condValue), $condOperator));
                return $this->compareValues(strtolower($dataValue), strtolower($condValue), $condOperator);
            case "date":
                $date1 = DateTime::createFromFormat('d-m-Y', $dataValue);
                $date2 = DateTime::createFromFormat('d-m-Y', $condValue);
                // print_r($this->compareValues($date1, $date2, $condOperator));
                return $this->compareValues($date1, $date2, $condOperator);
        }
    }

    public function compareValues($value1, $value2, $operator)
    {
        // echo 1213;
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