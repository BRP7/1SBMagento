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
        foreach ($xmlPartNumbers as $part) {
            if (empty($this->getMasterTableData())) {
                $model = Mage::getModel('ccc_filetransfer/master');
                $model->setData($part);
                try {
                    $model->save();
                } catch (Exception $e) {
                    Mage::logException($e);
                    echo 'Error saving part number: ' . $e->getMessage();
                }
            } else {
                $masterData = $this->getMasterTableData();
                $this->processPartNumbers($xmlPartNumbers, $masterData);
                break;
            }
        }
    }

    function processPartNumbers($xmlPartNumbers, $masterData)
    {
        $newPartNumbers = array_diff($xmlPartNumbers, array_keys($masterData));
        $existingPartNumbers = array_intersect($xmlPartNumbers, array_keys($masterData));
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
            $xmlPartNumbersFlat = array_column($newPartNumbers, 'part_no');
            if (!in_array($key, $xmlPartNumbersFlat)) {
                // $disModel=;
                if (!Mage::getModel('ccc_filetransfer/distable')->getCollection()->addFieldToFilter('port_no', $key)) {
                    $entityId = $masterData[$partNumber];
                    $model = Mage::getModel('ccc_filetransfer/distable');
                    $model->setEntityId($partNumber);
                    $model->setPartNo($key);
                    $model->save();
                    $result = array_filter($xmlPartNumbersFlat, function($value) use ($key) {
                        return $value != $key;
                    });
                    $xmlPartNumbersFlat = array_values($result);
                }
            } else {
               $this->masterSaveNewPort($xmlPartNumbersFlat);
                break;

                // foreach($xmlPartNumbersFlat as $partNumber){
                // $model = Mage::getModel('ccc_filetransfer/master');
                // if(!$model->getCollection()->addFieldToFilter('port_no', $key)){
                //     $model->setPartNo($key);
                //     $model->setEntityId($partNumber);
                //     $model->save();
                // }
            }
            }
        

        foreach ($existingPartNumbers as $partNumber) {
            $entityId = $masterData[$partNumber]['entity_id'];
            if (in_array($partNumber, array_column($newPartNumbers, 'part_no'))) {
                $model = Mage::getModel('ccc_filetransfer/master')->load($entityId);
                $model->setPartNo($partNumber);
                $model->save();
            }
        }


        foreach ($newPartNumbers as $partNumber) {
            $model = Mage::getModel('ccc_filetransfer/master');
            $model->setPartNo($partNumber['part_no']);
            $model->save();
            $entityId = $model->getId();
            $newTableModel = Mage::getModel('ccc_filetransfer/newtable');
            $newTableModel->setPartNo($partNumber['part_no']);
            $newTableModel->setEntityId($entityId);
            $newTableModel->save();
        }

    }

    public function masterSaveNewPort($data){
            foreach($data as $port){
            $model = Mage::getModel('ccc_filetransfer/master');
            $Id=$model->setPartNo($data)->save();
            $this->newSaveNewPort($port,$Id);
            }
    }

    public function newSaveNewPort($port,$id){
        $newTableModel = Mage::getModel('ccc_filetransfer/newtable');
            $newTableModel->setPartNo($port);
            $newTableModel->setEntityId($id);
            $newTableModel->save();
    }
}
