<?php
class Ccc_Filetransfer_Model_Master extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_filetransfer/master');
    }

    function getMasterTableData()
    {
        $masterTable = Mage::getModel('ccc_filetransfer/master')->getCollection();
        $masterData = [];

        foreach ($masterTable as $item) {
            $masterData[$item->getPartNo()] = $item->getEntityId();
        }
        return $masterData;
    }

    public function saveDataToMaster($xmlPartNumbers)
    {
        if (empty($this->getMasterTableData())) {
            foreach ($xmlPartNumbers as $part) {
                $model = Mage::getModel('ccc_filetransfer/master');
                $model->setData($part);
                try {
                    $model->save();
                } catch (Exception $e) {
                    Mage::logException($e);
                    echo 'Error saving part number: ' . $e->getMessage();
                }
            }
        } else {
            $masterData = $this->getMasterTableData();
            $this->processPartNumbers($xmlPartNumbers, $masterData);
        }

    }



    function processPartNumbers($xmlPartNumbers, $masterData)
    {
        // $newPartNumbers = array_diff($xmlPartNumbers, array_keys($masterData));
        // $existingPartNumbers = array_intersect($xmlPartNumbers, array_keys($masterData));
        // $discontinuedPartNumbersKeys = array_diff(array_keys($masterData), $xmlPartNumbers);
        // $discontinuedPartNumbers = [];

        // foreach ($discontinuedPartNumbersKeys as $key) {
        //     $partNumber = $key; // Part number is the key in the $masterData array
        //     $entityId = $masterData[$key]; // Entity ID is the value in the $masterData array
        //     $discontinuedPartNumbers[$partNumber] = $entityId;
        // }

        // foreach ($discontinuedPartNumbers as $partNumber) {
        // $xmlPartNumbersFlat = array_column($xmlPartNumbers, 'part_no');
        // print_r(!in_array($partNumber, $xmlPartNumbersFlat));
        // }
        // print_r($discontinuedPartNumbers);
        foreach ($masterData as $key => $partNumber) {
            $xmlPartNumbersFlat = array_column($xmlPartNumbers, 'part_no');
            $collection =Mage::getModel('ccc_filetransfer/distable')->getCollection()->addFieldToFilter('entity_id', $partNumber);
            if (!in_array($key, $xmlPartNumbersFlat)) {
                if ($collection->getSize() == 0) {
                // $entityId = $masterData[$partNumber];
                $model = Mage::getModel('ccc_filetransfer/distable');
                $model->setEntityId($partNumber);
                $model->setPartNo($key);
                $model->save();
                // $result = array_filter($xmlPartNumbersFlat, function ($value) use ($key) {
                //     return $value != $key;
                // });
                // $xmlPartNumbersFlat = array_values($result);

                // var_dump($xmlPartNumbersFlat);
                }
            }



            // foreach($xmlPartNumbersFlat as $partNumber){
            // $model = Mage::getModel('ccc_filetransfer/master');
            // if(!$model->getCollection()->addFieldToFilter('port_no', $key)){
            //     $model->setPartNo($key);
            //     $model->setEntityId($partNumber);
            //     $model->save();
            // }
        }
        $this->NewEntries($xmlPartNumbers, $masterData);
    }


    // foreach ($existingPartNumbers as $partNumber) {
    //     $entityId = $masterData[$partNumber]['entity_id'];
    //     if (in_array($partNumber, array_column($newPartNumbers, 'part_no'))) {
    //         $model = Mage::getModel('ccc_filetransfer/master')->load($entityId);
    //         $model->setPartNo($partNumber);
    //         $model->save();
    //     }
    // }


    // foreach ($newPartNumbers as $partNumber) {
    //     $model = Mage::getModel('ccc_filetransfer/master');
    //     $model->setPartNo($partNumber['part_no']);
    //     $model->save();
    //     $entityId = $model->getId();
    //     $newTableModel = Mage::getModel('ccc_filetransfer/newtable');
    //     $newTableModel->setPartNo($partNumber['part_no']);
    //     $newTableModel->setEntityId($entityId);
    //     $newTableModel->save();
    // }



    public function NewEntries($xmlPartNumbers, $masterData)
    { 
        $masterArray = array_column($masterData, 'part_no');
        foreach ($xmlPartNumbers as $key => $partNumber) {
            if (!in_array($key, $masterArray)) {
                $this->masterSaveNewPort($partNumber['part_no']);
            }
        }
    }

    public function masterSaveNewPort($port)
    {
        $model = Mage::getModel('ccc_filetransfer/master');
        $collection = $model->getCollection()
                            ->addFieldToFilter('main_table.part_no', $port);
        if ($collection->getSize() == 0) {
            $model->setPartNo($port)->save();
            $this->newSaveNewPort($port, $model->getId());
        } else {
            $firstItem = $collection->getFirstItem();
            $id = $firstItem->getId(); 
            $model->setData(['entity_id'=>$id, 'part_no'=>$port])->save();
        }
    }
    



    public function newSaveNewPort($port, $id)
    {
        $newTableModel = Mage::getModel('ccc_filetransfer/newtable');
        $collection = $newTableModel->getCollection()
                                    ->addFieldToFilter('main_table.entity_id', $id);
        if ($collection->getSize() !== 0) {
            $newTableModel->setId($collection->getFirstItem()->getId())
                          ->setPartNo($port)
                          ->setEntityId($id)
                          ->save();
        } else {
            $newTableModel->setPartNo($port)
                          ->setEntityId($id)
                          ->save();
        }
    }
    
}
