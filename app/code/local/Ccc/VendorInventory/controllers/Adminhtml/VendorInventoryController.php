<?php
class Ccc_VendorInventory_Adminhtml_VendorInventoryController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        // echo 12;
        // $this->loadLayout();
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

    protected function _validateFormKey()
    {
        return true;
    }

    // public function uploadAction()
    // {
    //     if (isset($_POST['jsonData'])) {
    //         // Retrieve JSON data and decode it into a PHP array
    //         $jsonData = $_POST['jsonData'];
    //         $configArray = json_decode($jsonData, true);

    //         // Find and remove the brand ID

    //         $brandId = key($configArray); // Get the first key (brand ID)
    //         $response['test'] = $configArray[$brandId];
    //         $configArray = $response['test'] ;

    //         // unset($configArray[$brandId]); // Remove the brand ID

    //         // Initialize arrays to hold data for each section
    //         $sections = array(
    //             'sku' => array(),
    //             'instock' => array(),
    //             'instock qty' => array(),
    //             'restock date' => array(),
    //             'restock qty' => array(),
    //             'status' => array(),
    //             'discontinued' => array()
    //         );

    //         // Iterate through the remaining data and divide it into sections
    //         foreach ($configArray as $sectionKey => $sectionData) {
    //             foreach ($sectionData as $subsectionKey => $subsectionData) {
    //                 // Add subsection data to its respective section
    //                 $sections[$subsectionKey][] = $subsectionData;
    //             }
    //         }
    //         $response['test'] = $sections;

    //         // Serialize data for each section
    //         $serializedSections = array();
    //         foreach ($sections as $sectionKey => $sectionData) {
    //             // Serialize section data
    //             $serializedData = json_encode($sectionData);
    //             // Add serialized data to array
    //             $serializedSections[$sectionKey] = $serializedData;
    //         }
    //         $this->getResponse()->setHeader('Content-type', 'application/json');
    //         // $this->getResponse()->setBody(json_encode($serializedSections));
    //         $this->getResponse()->setBody(json_encode($response));
    //         // print_r($serializedSections);
    //     }
    // }


    public function uploadAction()
    {

        $jsonData = $this->getRequest()->getParam('jsonData');
        // Decode JSON data
        $configArray = json_decode($jsonData, true);
        $brand_id = key($configArray);
        $configArray = $configArray[$brand_id];
        $data = ['brand_id' => $brand_id];
        // echo $brand_id;die;
        $config = Mage::getModel('vendorinventory/vendorinventory')->setData($data)->save();
        $id = $config->getId();
        // Retrieve JSON data from POST request
        // print_r($configArray);
        // $serializedData = [];
        // foreach ($configArray as $key => $value) {
        // 	foreach ($value as $_key => $_value) {
        // 		foreach ($_value as $k => $v) {

        // 			$serializedData[$_key][$k] = serialize($v);
        // 		}
        // 	}
        // }


        Mage::getModel('vendorinventory/configdata')->setData(['config_id' => $id])->addData([
            'brand_data' => serialize($configArray)
        ])->save();

        print_r(serialize($configArray));
    }

    // public function getheadersAction()
    // {
    //     // echo 2222;die;
    //     $response = array();
    //     $brandId = $this->getRequest()->getPost('brand_id');
    //     if ($brandId) {
    //         $brandData = Mage::getModel("vendorinventory/vendorinventory")->getCollection()
    //             ->addFieldToFilter("brand_id", $brandId)
    //             ->getData();
    //         if ($brandData) {
    //             $configId = $brandData[0]['config_id'];
    //             $responseData = Mage::getModel('vendorinventory/configdata')->getCollection()
    //                 ->addFieldToFilter('config_id', $configId)
    //                 ->getData();
    //             $response['brand_data'] = unserialize($responseData[0]['brand_data']);
    //         }

    //     }
    //     $response['files'] = $_FILES;
    //     // $response['brand_id'] = $_FILES;
    //     if (isset($_FILES['file-upload'])) {
    //         $response['headers'] = $this->processCsvFile($_FILES['file-upload']['tmp_name']);
    //     }
    //     // $this->getResponse()->setBody(json_encode($response));
    //     // return $this;
    //     $this->getResponse()->setHeader('Content-type', 'application/json');
    //     // $this->getResponse()->setBody(json_encode($response['brand_id']));
    //     $this->getResponse()->setBody(json_encode($response));
    // }


    // public function getheadersAction()
    // {
    //     $response = array();
    //     $brandId = $this->getRequest()->getPost('brand_id');
    //     if ($brandId) {
    //         $brandData = Mage::getModel("vendorinventory/vendorinventory")->getCollection()
    //             ->addFieldToFilter("brand_id", $brandId)
    //             ->getData();
    //         if ($brandData) {
    //             $configId = $brandData[0]['config_id'];
    //             $responseData = Mage::getModel('vendorinventory/configdata')->getCollection()
    //                 ->addFieldToFilter('config_id', $configId)
    //                 ->getData();
    //             if (!empty($responseData)) {
    //                 $brandData = unserialize($responseData[0]['brand_data']);
    //                 if ($brandData === false) {
    //                     $response['error'] = "Error unserializing data";
    //                 } else {
    //                     $response['brand_data'] = $brandData;
    //                     print_r($response['brand_data']);
    //                     die;
    //                 }
    //             } else {
    //                 $response['error'] = "No data found for config ID $configId";
    //             }
    //         } else {
    //             $response['error'] = "No brand data found for brand ID $brandId";
    //         }
    //     } else {
    //         $response['error'] = "No brand ID provided";
    //     }

    //     $response['files'] = $_FILES;
    //     if (isset($_FILES['file-upload'])) {
    //         $response['headers'] = $this->processCsvFile($_FILES['file-upload']['tmp_name']);
    //     }

    //     $this->getResponse()->setHeader('Content-type', 'application/json');
    //     $this->getResponse()->setBody(json_encode($response));
    // }

    //     public function getheadersAction()
// {
//     $response = array();
//     $brandId = $this->getRequest()->getPost('brand_id');

    //     if ($brandId) {
//         $brandData = Mage::getModel("vendorinventory/vendorinventory")->getCollection()
//             ->addFieldToFilter("brand_id", $brandId)
//             ->getData();

    //         if ($brandData) {
//             $configId = $brandData[0]['config_id'];
//             $responseData = Mage::getModel('vendorinventory/configdata')->getCollection()
//                 ->addFieldToFilter('config_id', $configId)
//                 ->getData();

    //             if (!empty($responseData)) {
//                 $brandData = unserialize($responseData[0]['brand_data']);

    //                 if ($brandData === false) {
//                     $response['error'] = "Error unserializing data";
//                 } else {
//                     $response['brand_data'] = $brandData;
//                 }
//             } else {
//                 $response['error'] = "No data found for config ID $configId";
//             }
//         } else {
//             $response['error'] = "No brand data found for brand ID $brandId";
//         }
//     } else {
//         $response['error'] = "No brand ID provided";
//     }

    //     $response['files'] = $_FILES;

    //     if (isset($_FILES['file-upload'])) {
//         $response['headers'] = $this->processCsvFile($_FILES['file-upload']['tmp_name']);
//     }

    //     $this->getResponse()->setHeader('Content-type', 'application/json');
//     $this->getResponse()->setBody(json_encode($response));
// }

    public function getheadersAction()
    {
        // echo 2222;die;
        $response = array();
        $brand_id = $this->getRequest()->getPost('brand_id');
        if ($brand_id) {
            $data = Mage::getModel('vendorinventory/vendorinventory')->getCollection()
                ->addFieldToFilter('brand_id', $brand_id)->getData();
                if ($data) {
            $config_id = $data[0]['config_id'];
            // echo $config_id;
            
                $brand_data = Mage::getModel('vendorinventory/configdata')->getCollection()
                    ->addFieldToFilter('config_id', $config_id)->getData();
                $response['brand'] = unserialize($brand_data[0]['brand_data']);
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
        // echo "Hello World!";
        echo "<pre>";
        print_r($this->getRequest()->getPost());
    }






}
