<?php
class Ccc_Filetransfer_Model_Ftp extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('ccc_filetransfer/ftp');
    }
    public function saveExtractedFilesData($extractPath, $configId)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($extractPath));
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $path = explode(Mage::helper('ccc_filetransfer')->getFileUrl(), $file->getPath());
                $data = array(
                    'file_name' => $file->getFilename(),
                    'file_path' => $path[1],
                    'configuration_id' => $configId
                );
                Mage::getModel('ccc_filetransfer/ftp')->setData($data)->save();
            }
        }
    }
    public function convertXmlToArray($xml)
    {
        $rows = [];
        foreach ($xml->items->children() as $key => $child) {
            $row = [];
            $this->parseXml($child, $row, $key);
            $rows[] = $row;
        }
        return $rows;
    }
    public function parseXml($xml, &$row, $parent)
    {
        foreach ($xml->children() as $key => $child) {
            $header = $parent ? $parent . '_' . $key : $key;
            if ($child->count() > 0) {
                $this->parseXml($child, $row, $header);
            } else {
                $value = isset($child)
                    ? $child : null;
                $row[$header][] = $value;
            }
        }
    }
    public function convertArrayToCsv($array)
    {
        if (empty($array)) {
            return '';
        }
        $csv = '';
        $headers = [];
        foreach ($array as $row) {
            $headers = array_merge($headers, array_keys($row));
        }
        $headers = array_unique($headers);
        $csv .= implode(',', $headers) . "\n";
        foreach ($array as $row) {
            $csvRow = [];
            foreach ($headers as $header) {
                if (isset($row[$header])) {
                    if (is_array($row[$header])) {
                        $csvRow[] = '"' . implode(',', $row[$header]) . '"';
                    } else {
                        $csvRow[] = $row[$header];
                    }
                } else {
                    $csvRow[] = '';
                }
            }
            $csv .= implode(',', $csvRow) . "\n";
        }
        return $csv;
    }
}
?>