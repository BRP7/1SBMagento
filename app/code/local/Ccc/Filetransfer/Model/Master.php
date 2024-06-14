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
            if (!$this->getMasterTableData()) {
                $model = Mage::getModel('ccc_filetransfer/master');
                $model->setData($part);
                try {
                    var_dump($model->getData());
                    // $model->save();
                } catch (Exception $e) {
                    Mage::logException($e); 
                    echo 'Error saving part number: ' . $e->getMessage(); 
                }
            } else {
                $masterData = $this->getMasterTableData();
                $this->processPartNumbers($xmlPartNumbers,$masterData);
            }
        }
    }

    function processPartNumbers($xmlPartNumbers, $masterData)
    {
        echo 1234;
        $newPartNumbers = array_diff($xmlPartNumbers, array_keys($masterData));
        $discontinuedPartNumbers = array_diff(array_keys($masterData), $xmlPartNumbers);
        $existingPartNumbers = array_intersect($xmlPartNumbers, array_keys($masterData));

        foreach ($existingPartNumbers as $partNumber) {
            $entityId = $masterData[$partNumber];
            $model = Mage::getModel('ccc_filetransfer/master')->load($entityId);
            $model->save();
        }


        foreach ($discontinuedPartNumbers as $partNumber) {
            $entityId = $masterData[$partNumber];
            $model = Mage::getModel('ccc_filetransfer/distable');
            $model->setEntityId($entityId);
            $model->setPartNo($partNumber);
            $model->save();
        }

        foreach ($newPartNumbers as $partNumber) {
            $model = Mage::getModel('ccc_filetransfer/newtable');
            $model->setPartNumber($partNumber);
            $model->save();
        }
    }


}
?>