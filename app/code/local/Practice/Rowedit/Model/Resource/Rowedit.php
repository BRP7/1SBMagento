<?php
class Practice_Rowedit_Model_Resource_Rowedit extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('practice_rowedit/rowedit', 'entity_id');
    }
}


// mysql inplace of resources
// class Practice_Rowedit_Model_Mysql4_Rowedit extends Mage_Core_Model_Mysql4_Abstract
// {
//     protected function _construct()
//     {
//         $this->_init('rowedit/rowedit', 'entity_id');
//     }
// }
