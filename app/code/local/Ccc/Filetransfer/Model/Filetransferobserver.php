<?php

class Ccc_Filetransfer_Model_Filetransferobserver extends Varien_Io_Ftp
{
    protected $_configData;


    public function setConfigData($config)
    {
        $this->_configData = $config;
        return $this;
    }

    public function setConnection($conn)
    {
        $this->_conn = $conn;
        return $this;
    }
    // protected function isDirectory($filepath)
    // {
    //     $listing = ftp_mlsd($this->_conn, $filepath['text']); 
    //     if ($listing === false || count($listing) === 0) {
    //         return false;
    //     }
    //     $firstItem = $listing[0];
    //     return $firstItem['type'] === 'dir';
    // }
    // public function readAndSave($filepath)
    // {
    //     if ($this->isDirectory($filepath)) {
    //         $this->recursiveReadAndSaveDirectory($filepath);
    //     } else {
    //         // echo $filepath;
    //         $this->saveAndDownloadFiles($filepath);
    //     }
    // }

    public function saveAndDownloadFiles($file)
    {
        $filepath = $file['text'];
        $filename = $this->getProperFileName($filepath);
        $localFilePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $this->_configData->getId() . DS . $filename;

        $directory = dirname($localFilePath);

        if (!is_dir($directory)) {
            echo "Directory does not exist: " . $directory;
            mkdir($directory, 0777, true);
        } elseif (!is_writable($directory)) {
            echo "Directory is not writable: " . $directory;
            chmod($directory, 0777);
        } else {
            echo "Directory exists and is writable: " . $directory;
        }

        echo "Trying to create file at: " . $localFilePath . "\n";

        $newFile = fopen($localFilePath, 'w');
        // var_dump($newFile);
        if ($newFile !== false) {
            fclose($newFile);
        } else {
            echo "Unable to create file: " . $localFilePath;
            throw new Exception('Failed to save attachment: ' . $localFilePath);
        }

        $fileContents = $this->read($filepath);
        if ($fileContents !== false) {
            file_put_contents($localFilePath, $fileContents);

        } else {
            Mage::log('FTP file read failed for file: ' . $filepath, null, 'ftp_errors.log');
            throw new Exception('Failed to save attachment: ' . $filepath);
        }
        $this->saveFileToDb($filepath);
        $this->moveFile($filepath);
    }
    // public function moveFile($filepath) {
    //     $pathInfo = pathinfo($filepath);
    //     $filename = $pathInfo['basename'];
    //     $destinationPath = 'downloadedfiles' . DS . $filename;

    //     if (!is_dir('downloadedfiles')) {
    //         mkdir('downloadedfiles', 0777, true);
    //     }

    //     echo "Moving file from $filepath to $destinationPath\n";

    //     $moveResult = $this->mv( $filepath, $destinationPath);
    //     if ($moveResult) {
    //         echo "File moved successfully to $destinationPath\n";
    //     } else {
    //         echo "Failed to move file: $filepath to $destinationPath\n";
    //         $error = error_get_last();
    //         echo "Error details: " . $error['message'] . "\n";
    //         Mage::log('FTP move failed for file: ' . $filepath . ' to ' . $destinationPath . '. Error: ' . $error['message'], null, 'ftp_errors.log');
    //         throw new Exception('Failed to move file: ' . $filepath);
    //     }

    //     // Check if the file still exists at the source
    //     if (file_exists($filepath)) {
    //         echo "File still exists at source: $filepath\n";
    //     } else {
    //         echo "File no longer exists at source: $filepath\n";
    //     }

    //     // Remove the file if it was successfully moved
    //     if ($moveResult) {
    //         $this->rm($filepath);
    //     }
    // }



    public function moveFile($filepath)
    {
        $pathInfo = pathinfo($filepath);
        $filename = $pathInfo['basename'];
        // var_dump($filename);
        $destinationPath = 'downloadedfiles/' . $filename;
        // var_dump($destinationPath);

        if (!is_dir('downloadedfiles')) {
            mkdir('downloadedfiles', 0777, true);
        }

        $moveResult = $this->mv($filepath, $destinationPath);
        if ($moveResult) {
            echo "File moved successfully to $destinationPath\n";
            $this->rm($filepath);
        } else {
            $error = error_get_last();
            echo "Error details: " . $error['message'] . "\n";
            Mage::log('FTP move failed for file: ' . $filepath . ' to ' . $destinationPath . '. Error: ' . $error['message'], null, 'ftp_errors.log');
            throw new Exception('Failed to move file: ' . $filepath);
        }
    }


    public function saveFileToDb($filepath)
    {
        $creationDate = $this->getFileCreationDate($filepath);
        $configurationId = $this->_configData->getId();
        $fileModel = Mage::getModel('ccc_filetransfer/filetransfer');
        $fileData = $fileModel->setFilePath($filepath)
            ->setConfigurationId($configurationId)
            ->setFileDate($creationDate)
            ->save();
        // var_dump($fileData->getData());
    }

    public function getProperFileName($filepath, $configId = '', $date = "")
    {
        if ($configId != '') {
            $configurationId = $configId;
        } else {
            $configurationId = $this->_configData->getId();
        }
        if ($date != '') {
            $creationDate = $date;
        } else {
            $creationDate = $this->getFileCreationDate($filepath);
        }

        $newDate = str_replace(" ", "_", $creationDate);
        $fileNewPath = str_replace("./", '', $filepath);

        $fileNewPath = $configurationId . '_' . $newDate . '_' . $fileNewPath;
        $filename = preg_replace('/[^\w\-\.]/', '_', $fileNewPath);
        return $filename;
    }

    protected function getFileCreationDate($filepath)
    {
        $lastModifiedTime = ftp_mdtm($this->_conn, $filepath);
        if ($lastModifiedTime === -1) {
            var_dump('can not get date');
            return null;
        } else {
            $creationDate = date('Y-m-d H:i:s', $lastModifiedTime);
            $creationDate = str_replace(" ", "_", $creationDate);
            return $creationDate;
        }
    }

    // protected function recursiveReadAndSaveDirectory($directory)
    // {
    //     $contents = $this->ls($directory);

    //     foreach ($contents as $item) {
    //         $itemPath = $directory . DS . $item['text'];

    //         if ($this->isDirectory($itemPath)) {
    //             $this->recursiveReadAndSaveDirectory($itemPath);
    //         } else {
    //             $this->saveAndDownloadFiles($itemPath);
    //         }
    //     }
    // }


    // public function convertXml($id, $configId, $path)
    // {
    //     $dataObj = Mage::getModel('ccc_filetransfer/filetransfer')->load($id);
    //     $date = ($dataObj->getFileDate());
    //     $filepath = $this->getProperFileName($path, $configId, $date);
    //     $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $configId . DS . $filepath;
    //     if (!file_exists($filePath)) {
    //         throw new Exception('File not found: ' . $filePath);
    //     }



    //     $xml = simplexml_load_file($filePath);
    //     if ($xml === false) {
    //         throw new Exception('Failed to load XML file: ' . $filePath);
    //     }

    //     // Open a CSV file for writing
    //     $csvFilePath = str_replace('.xml', '.csv', $filePath);
    //     $csvFile = fopen($csvFilePath, 'w');

    //     // Write the headers based on XML hierarchy
    //     $headers = [];
    //     foreach ($xml->children() as $child) {
    //         var_dump($child);
    //         echo "<br>";
    //         foreach ($child->children() as $subchild) {
    //             var_dump($subchild);
    //             $headers[] = $subchild->getName();
    //         }
    //     }
    //     fputcsv($csvFile, $headers);

    //     // Write the data rows
    //     foreach ($xml->children() as $child) {
    //         $rowData = [];
    //         foreach ($child->children() as $subchild) {
    //             $rowData[] = (string) $subchild;
    //         }
    //         fputcsv($csvFile, $rowData);
    //     }

    //     // Close the CSV file
    //     fclose($csvFile);

    //     echo 'CSV file created successfully: ' . $csvFilePath;

    // }


    // public function convertXml($id, $configId, $path)
    // {
    //     $dataObj = Mage::getModel('ccc_filetransfer/filetransfer')->load($id);
    //     $date = $dataObj->getFileDate();
    //     $filepath = $this->getProperFileName($path, $configId, $date);
    //     $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $configId . DS . $filepath;
    //     $csvFilePath = str_replace('.xml', '.csv', $filePath);

    //     if (!file_exists($filePath)) {
    //         throw new Exception('File not found: ' . $filePath);
    //     } elseif (filesize($filePath) == 0) {
    //         throw new Exception('File is empty: ' . $filePath);
    //     }

    //     // $xmlContent = file_get_contents($filePath);
    //     // if ($xmlContent === false) {
    //     //     throw new Exception('Failed to read XML file: ' . $filePath);
    //     // }

    //     // Log the content to check for hidden characters
    //     // Mage::log('XML Content: ' . $xmlContent, null, 'filetransfer.log', true);

    //     // $xml = simplexml_load_string($xmlContent);
      
    //     if ($filePath === false) {
    //         throw new Exception('Failed to load XML content. Possible syntax error in XML file: ' . $filePath);
    //     }

    //     // Set memory and execution time limits
    //     // ini_set('memory_limit', '1024M');
    //     // set_time_limit(0);

    //     // Open the CSV file for writing
    //     $outputHandle = fopen($csvFilePath, 'w');

    //     $reader = new XMLReader();
    //     $reader->open($filePath);

    //     $headers = [];
    //     $rows = [];

    //     while ($reader->read()) {
    //         if ($reader->nodeType == XMLReader::ELEMENT && $reader->localName == 'items') {
    //             $node = $reader->expand();
    //             $data = $this->processNode($node);
    //             $headers = array_unique(array_merge($headers, array_keys($data)));
    //             $rows[] = $data;
    //         }
    //     }

    //     // Write headers to CSV
    //     fputcsv($outputHandle, $headers);

    //     // Write rows to CSV
    //     foreach ($rows as $row) {
    //         $rowData = [];
    //         foreach ($headers as $header) {
    //             $rowData[] = isset($row[$header]) ? $row[$header] : '';
    //         }
    //         fputcsv($outputHandle, $rowData);
    //     }

    //     $reader->close();
    //     fclose($outputHandle);

    //     echo "Conversion complete. CSV file saved to $csvFilePath\n";
    // }

    function processNode($node, $prefix = '')
{
    $result = [];

    // Process attributes first
    if ($node->hasAttributes()) {
        foreach ($node->attributes as $attr) {
            // Append attribute name to prefix
            $key = $prefix . $attr->name;
            // Store attribute value
            $result[$key] = $attr->value;
        }
    }

    // Process child nodes
    foreach ($node->childNodes as $child) {
        if ($child->nodeType == XML_ELEMENT_NODE) {
            // Recursively process child elements
            $childResult = $this->processNode($child, $prefix . $node->localName . '_');
            // Merge child results with current result
            $result = array_merge($result, $childResult);
        }
    }

    // If no child elements, store text content as value
    if (empty($result) && $node->nodeType == XML_TEXT_NODE && trim($node->textContent) !== '') {
        // Append tag name to prefix
        $key = $prefix . $node->localName;
        // Store text content as value
        $result[$key] = $node->textContent;
    }

    return $result;
}


    public function convertXml($id,$configId,$path){
        $fileModel = Mage::getModel('ccc_filetransfer/filetransfer')
        ->load($id);
        if ($fileModel && $fileModel->getId()) {
            $date = ($fileModel->getFileDate());
            $filepath = $this->getProperFileName($path, $configId, $date);
            $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $configId . DS . $filepath;
            // echo $filePath;
        // var_dump($filePath);
        if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'xml') {
            $xmlContent = file_get_contents($filePath);
            $xml = new SimpleXMLElement($xmlContent);
            $xmlArray = $this->convertXmlToArray($xml);
            $data = $this->convertArrayToCsv($xmlArray);
            // var_dump([pathinfo($filePath, PATHINFO_FILENAME),$data ]);
            return [pathinfo($filePath, PATHINFO_FILENAME),$data];
            // $this->_prepareDownloadResponse(pathinfo($filePath, PATHINFO_FILENAME) . '.csv', $csvData, 'text/csv');

            // print_r($xmlArray);
    }
    }
}

protected function convertXmlToArray($xml, $parent = '')
{
    $rows = [];
    foreach ($xml->items->children() as $key => $child) {
        $row = [];
        $this->parseXml($child, $row, $key);
        $rows[] = $row;
        }
        return $rows;
        }
        
        protected function parseXml($xml, &$row, $parent)
        {
            
       foreach ($xml->children() as $key => $child) {
        $header = $parent ? $parent . '_' . $key : $key;
        if ($child->count() > 0) {
            $this->parseXml($child, $row, $header);
            } else {
                $value = isset($child['value'])
                ? (string) $child['value'] : null;
                $row[$header] = $value;
        }
    }
}
protected function convertArrayToCsv($array)
{
    if (empty($array)) {
        return '';
        }
        $csv = '';
        $headers = [];
        foreach ($array as $row) {
        foreach ($row as $key => $value) {
            if (!in_array($key, $headers)) {
                $headers[] = $key;
            }
        }
    }
    $csv .= implode(',', $headers) . "\n";
    foreach ($array as $row) {
        $csvRow = [];
        foreach ($headers as $header) {
            $csvRow[] = isset($row[$header]) ? $row[$header] : '';
        }
        $csv .= implode(',', $csvRow) . "\n";
    }
    return $csv;
}





    public function extractXml($id, $configId, $path)
    {
        $dataObj = Mage::getModel('ccc_filetransfer/filetransfer')->load($id);
        $date = $dataObj->getFileDate();
        $filepath = $this->getProperFileName($path, $configId, $date);
        $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $configId . DS . $filepath;

        if (!file_exists($filePath)) {
            throw new Exception('File not found: ' . $filePath);
        }

       

        if (pathinfo($filePath, PATHINFO_EXTENSION) !== 'zip') {
            Mage::getSingleton('adminhtml/session')->addError('The selected file is not a ZIP file.');
            return;
        }

        try {
            $extractPath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $configId . DS;

            if (!is_dir($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $extractedFiles = $this->unzip($filePath, $extractPath);
            if ($extractedFiles) {
                foreach ($extractedFiles as $extractedFile) {
                    $this->saveExtractedFileToDb($extractedFile, $configId, $date);
                }
                echo "ZIP file extracted successfully to: " . $extractPath . "\n";
                Mage::getSingleton('adminhtml/session')->addSuccess('ZIP file extracted successfully.');
            } else {
                throw new Exception('ZIP file extraction failed.');
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError('Error: ' . $e->getMessage());
        }
    }


    private function unzip($filePath, $extractPath)
    {
        $zip = new ZipArchive;
        $extractedFiles = [];

        if ($zip->open($filePath) === TRUE) {
            $zip->extractTo($extractPath);

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $extractedFiles[] = $extractPath . $zip->getNameIndex($i);
            }

            $zip->close();
            return $extractedFiles;
        }

        return false;
    }



    public function saveExtractedFileToDb($filepath, $configId, $date)
    {
        $fileModel = Mage::getModel('ccc_filetransfer/filetransfer');
        $fileData = $fileModel->setFilePath($filepath)
            ->setConfigurationId($configId)
            ->setFileDate($date)
            ->save();
        echo "data save to db!!";
    }

}
