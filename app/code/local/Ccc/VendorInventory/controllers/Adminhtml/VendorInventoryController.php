<?php
class Ccc_VendorInventory_Adminhtml_VendorInventoryController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->_title($this->__("Manage Inventory"));
        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('ccc_vendorinventory/vendorinventory');
        return $this;
    }

    // protected function _validateFormKey()
    // {
    //     return true;
    // }

    public function uploadAction()
    {
        $jsonData = $this->getRequest()->getParam('jsonData');
        $configArrayData = json_decode($jsonData, true);
        $brand_id = key($configArrayData);
        $configArray = $configArrayData[$brand_id];
        $data = ['brand_id' => $brand_id];
        if (isset($configArrayData["config_id"])) {
            $configId = $configArrayData["config_id"];
            $primaryId = $configArrayData["primary_key"];
            // $config = Mage::getModel('vendorinventory/vendorinventory')->setData($data)->addData(['config_id' => $configId])->save();
            Mage::getModel('vendorinventory/configdata')->setData(['config_id' => $configId, "id" => $primaryId])->addData([
                'brand_data' => serialize($configArray)
            ])->save();
        } else {
            $config = Mage::getModel('vendorinventory/vendorinventory')->setData($data)->save();
            $id = $config->getId();
            Mage::getModel('vendorinventory/configdata')->setData(['config_id' => $id])->addData([
                'brand_data' => serialize($configArray)
            ])->save();
        }
        print_r(serialize($configArray));
    }


    public function getheadersAction()
    {
        $response = array();
        $brand_id = $this->getRequest()->getPost('brand_id');
        if ($brand_id) {
            $data = Mage::getModel('vendorinventory/vendorinventory')->getCollection()
                ->addFieldToFilter('brand_id', $brand_id)->getData();
            if ($data) {
                $config_id = $data[0]['config_id'];
                $brand_data = Mage::getModel('vendorinventory/configdata')->getCollection()
                    ->addFieldToFilter('config_id', $config_id)->getFirstItem();
                $response['brand'] = unserialize($brand_data->getBrandData());
                $response['config_id'] = $config_id;
                $response['id'] = $brand_data->getId();
            }
        }

        $response['files'] = $_FILES;
        if (isset($_FILES['file-upload'])) {
            $response['headers'] = $this->processCsvFile($_FILES['file-upload']['tmp_name']);
        }
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($response));
    }



    private function processCsvFile($csvFilePath)
    {
        $headers = array();
        if (($handle = fopen($csvFilePath, "r")) !== false) {
            if (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $headers = $data;
            }
            fclose($handle);
        }
        return $headers;
    }

    public function saveAction()
    {
        echo "<pre>";
        print_r($this->getRequest()->getPost());
    }






}
