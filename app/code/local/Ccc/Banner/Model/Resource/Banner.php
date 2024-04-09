<?php
class Ccc_Banner_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        // parent::_construct();
        $this->_init('ccc_banner/banner', 'banner_id');
    }
//     public function getBannerCollection()
//     {
//         $collection = $this->_getReadAdapter()->select()->from($this->getMainTable());
//         // echo "<pre>";
//         $collection->limit(2);
//         // print_r($collection);
//         // die;
//         // Optionally, apply filters
//         // $collection->where('some_column = ?', $someValue);

//         // Optionally, apply sorting
//         // $collection->order('some_column ASC');

//         // Optionally, apply limits or pagination

//         // Convert the select object to a collection
//         $collection = Mage::getModel('ccc_banner/banner')->getCollection()->setConnection($this->_getReadAdapter());

//         // Return the collection
//         return $collection;
    
// }

}

?>


