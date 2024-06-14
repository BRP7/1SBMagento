<?php
class Ccc_Filetransfer_Adminhtml_FiletransferController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ccc_filetransfer/filetransfer');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Manage Configuration'));
        $this->_initAction();
        $this->renderLayout();
    }
    protected function newAction()
    {
        $this->_forward('edit');
    }
    protected function editAction()
    {
        $this->_title($this->__('ccc_filetransfer'))->_title($this->__('Filetransfer'));
        $id = $this->getRequest()->getParam('configuration_id');
        $model = Mage::getModel('ccc_filetransfer/configuration');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                    addError(Mage::helper('ccc_filetransfer')->
                        __('This File configuration no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Configuration'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('configuration_model', $model);
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('ccc_filetransfer')->__('Edit Configuration') : Mage::helper('ccc_filetransfer')->__('New Configuration'), $id ? Mage::helper('ccc_filetransfer')->__('Edit Configuration') : Mage::helper('ccc_filetransfer')->__('New Configuration'));
        $this->renderLayout();
    }
    protected function saveAction()
    {
        if ($data = $this->getRequest()->getParams()) {
            $model = Mage::getModel('ccc_filetransfer/configuration');
            if ($id = $this->getRequest()->getParam('configuration_id')) {
                $model->load($id);
            }
            $model->setData($data);
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ccc_filetransfer')->__('The Configuration has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('configuration_id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('ccc_filetransfer')->__('An error occurred while saving the Configuration.')
                );
            }
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('configuration_id' => $this->getRequest()->getParam('configuration_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('configuration_id')) {
            $title = "";
            try {
                $model = Mage::getModel('ccc_filetransfer/configuration');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ccc_filetransfer')->__('The product has been deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('mfr_id' => $id));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ccc_filetransfer')->__('Unable to find a product to delete.'));
        $this->_redirect('*/*/');
    }
    public function ftpAction()
    {
        $this->_title($this->__('Manage FTP'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function extractZipAction()
    {
        $fileModel = Mage::getModel('ccc_filetransfer/ftp')
            ->load($this->getRequest()->getParam('id'));
            var_dump($this->getRequest()->getParam('id'));
        
        if ($fileModel && $fileModel->getId()) {

            $rootPath = Mage::helper('ccc_filetransfer')->getFileUrl();
            $filePath = $rootPath . $fileModel->getFilePath() . DS . $fileModel->getFileName();
            if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'zip') {
                $zip = new ZipArchive;
                if ($zip->open($filePath) === TRUE) {
                    $extractedPath = $rootPath . $fileModel->getFilePath() . DS . pathinfo($filePath, PATHINFO_FILENAME);
                    ;
                    if (!file_exists($extractedPath)) {
                        mkdir($extractedPath, 0777, true);
                    }
                    $result = $zip->extractTo($extractedPath);
                    $zip->close();
                    if ($result) {
                        Mage::getModel('ccc_filetransfer/ftp')
                            ->saveExtractedFilesData($extractedPath, $fileModel->getConfigurationId());
                    }
                    $this->_getSession()->addSuccess($this->__('ZIP file extracted successfully.'));
                } else {
                    $this->_getSession()->addError($this->__('Failed to open the ZIP file.'));
                }
            }
        }
        $this->_redirect('*/*/ftp');
    }

    public function downloadCsvAction()
    {
        $fileModel = Mage::getModel('ccc_filetransfer/ftp')
            ->load($this->getRequest()->getParam('id'));
        if ($fileModel && $fileModel->getId()) {
            $filePath = Mage::helper('ccc_filetransfer')->getFileUrl() .
                $fileModel->getFilePath() . DS . $fileModel->getFileName();
            if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'xml') {
                $xmlContent = file_get_contents($filePath);
                $xml = new SimpleXMLElement($xmlContent);

                $ftpModel = Mage::getModel('ccc_filetransfer/ftp');
                $xmlArray = $ftpModel->convertXmlToArray($xml);
                // $csvData = $ftpModel->convertArrayToCsv($xmlArray);
                $filterdata = Mage::helper('ccc_filetransfer')
                    ->getXmlData();
                // print_r($xmlArray);
                $attribute = $this->getXmlAttribute($xmlArray, $filterdata);
                // $storeInMainTable = $this->readMainTableData($xmlArray, $filterdata);
                $csvData = $ftpModel->convertArrayToCsv($attribute);
                if (!empty($csvData)) {
                    $this->_prepareDownloadResponse(pathinfo($filePath, PATHINFO_FILENAME) . '.csv', $csvData, 'text/csv');
                    return;
                } else {
                    Mage::getSingleton('adminhtml/session')->addError('Failed to generate CSV data.');
                }
            }
        }
        // $this->_redirect('*/*/ftp');
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

