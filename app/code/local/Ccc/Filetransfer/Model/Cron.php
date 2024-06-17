<?php
class Ccc_Filetransfer_Model_Cron
{
    public function readFile()
    {
        try {
            $configurationCollection = Mage::getModel('ccc_filetransfer/configuration')
                ->getCollection();
            if ($configurationCollection) {
                foreach ($configurationCollection as $_configuration) {
                    $_configuration->fetchFiles();
                }
            }
        } catch (Exception $e) {
            Mage::log('Error reading files: ' . $e->getMessage(), null, 'ftp.log');
        }
    }

    public function readXmlFiles(){
        // $filePath = "C:/xampp\htdocs/1SBMagento/var\FileZilla/1\888-3061700-0-20240519162055_20240612_084829\888-3061700-0-20240519162055.xml";
        // $filePath = 'C:\xampp\htdocs\1SBMagento\var\FileZilla\1\fileForMasterConfiguration_20240614_153511.xml';
        $filePath = 'C:\xampp\htdocs\1SBMagento\var\FileZilla\1\item_8000_20240617_043749.xml';
        // $filePath="C:/xampp\htdocs/1SBMagento/var\FileZilla/1/newXmll_20240614_063328/newXmll.xml";
        if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'xml') {
            $xmlContent = file_get_contents($filePath);
            $xml = new SimpleXMLElement($xmlContent);
            $ftpModel = Mage::getModel('ccc_filetransfer/ftp');
            $xmlArray = $ftpModel->convertXmlToArray($xml);
            $filterdata = Mage::helper('ccc_filetransfer')
                ->getXmlData();
                // $attribute = $this->getXmlAttribute($xmlArray,$filterdata);
                $attribute =  $ftpModel->getXmlAttribute($xmlArray, $filterdata);
                Mage::getModel('ccc_filetransfer/master')->saveDataToMaster($attribute);
                // Mage::getModel('ccc_filetransfer/master')->saveDataToMaster($attribute);
            // $storeInMainTable = $this->readMainTableData($xmlArray, $filterdata);
            // $csvData = $ftpModel->convertArrayToCsv($attribute);
            // if (!empty($csvData)) {
            //     $this->_prepareDownloadResponse(pathinfo($filePath, PATHINFO_FILENAME) . '.csv', $csvData, 'text/csv');
            //     return;
            // } else {
            //     Mage::getSingleton('adminhtml/session')->addError('Failed to generate CSV data.');
            // }
        }

    }
    protected function getXmlAttribute($xml, $data)
    {
        $attribute = [];
        foreach ($data as $datakey => $row) {
            $splitArray = explode(':', $row);
            $tag = str_replace('.', '_', $splitArray[0]);
            $att = $splitArray[1];
            foreach ($xml as $key => $item) {
                if (!isset($attribute[$key])) {
                    $attribute[$key] = [];
                }
                foreach ($item as $itemkey => $value) {
                    foreach ($value as $attKey => $attValue) {
                        if ($itemkey == $tag) {
                            $attribute[$key][$datakey][] = (string) $attValue->attributes()->$att;
                        }
                    }
                }
            }
        }
        return $attribute;
    }
   
}