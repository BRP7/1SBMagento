<?php
class Ccc_Filetransfer_Model_Filetransfer extends Varien_Io_Ftp
{
    protected $_configModel;
    const TMPDIR = 'downloadedFiles';

    public function setConfiguration(Ccc_Filetransfer_Model_Configuration $configModel)
    {
        $this->_configModel = $configModel;
        return $this;
    }
    public function getConfiguration()
    {
        return isset($this->_configModel) ? $this->_configModel : null;
    }

    public function downloadAndStoreFiles($remoteDir = '', $localDir = '')
    {
        $errors = [];
        try {
            $this->open(
                array(
                    'host' => $this->_configModel->getHost(),
                    'user' => $this->_configModel->getUser(),
                    'password' => $this->_configModel->getPassword(),
                    'port' => $this->_configModel->getPort(),
                )
            );
            $baseLocalDir = Mage::helper('ccc_filetransfer')->getFileUrl() . DS .
                $this->_configModel->getId() . DS;
            if (!$localDir) {
                $localDir = $baseLocalDir;
            }
            if (!@ftp_chdir($this->_conn, self::TMPDIR)) {
                $this->mkdir(self::TMPDIR);
            }
            if (!file_exists($localDir)) {
                mkdir($localDir, 0777, true);
            }
            $this->recursiveDownload($remoteDir, $localDir, $errors);
            $this->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
        if (!empty($errors)) {
            throw new Exception(implode("\n", $errors));
        }
    }

    protected function recursiveDownload($remoteDir, $localDir, &$errors)
    {
        $list = ftp_rawlist($this->_conn, $remoteDir);
        foreach ($list as $item) {
            $chunks = preg_split("/\s+/", $item);
            $name = $chunks[8];
            if ($name == '.' || $name == '..') {
                continue;
            }
            $path = $remoteDir . '/' . $name;
            $localPath = $localDir . '/' . $name;
            if (substr($item, 0, 1) === 'd') {
                if ($path == '/' . self::TMPDIR) {
                    continue;
                } else if (!file_exists($localPath)) {
                    mkdir($localPath, 0777, true);
                }
                $tmpDir = self::TMPDIR . $path;
                if (!@ftp_chdir($this->_conn, $tmpDir)) {
                    $this->mkdir($tmpDir);
                }
                $this->recursiveDownload($path, $localPath, $errors);
            } else {
                $fileInfo = pathinfo($name);
                $extension = isset($fileInfo['extension']) ? '.' . $fileInfo['extension'] : '';
                $fileName = $fileInfo['filename'] . '_' . date('Ymd_His', ftp_mdtm($this->_conn, $path)) . $extension;
                $localFile = $localDir . '/' . $fileName;
                $this->read($path, $localFile);
                $data = array(
                    'file_name' => $fileName,
                    'file_path' => ($this->_configModel->getId() . $remoteDir)
                        ? DS . $this->_configModel->getId() . $remoteDir : DS,
                    'configuration_id' => $this->_configModel->getId()
                );
                Mage::getModel('ccc_filetransfer/ftp')->setData($data)->save();
                $result = $this->mv($path, self::TMPDIR . $path);
                if ($result) {
                    $remainingItems = ftp_rawlist($this->_conn, $remoteDir);
                    if (count($remainingItems) <= 2) {
                        $this->rmdir($remoteDir, true);
                    }
                } else {
                    $errors[] = "Failed to move file: $path";
                }
            }
        }
    }
}
?>