<?php
class Ccc_Filetransfer_Model_Resource_Master_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_filetransfer/master');
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()
            ->joinLeft(
                ['newpart' => $this->getTable('ccc_filetransfer/newtable')],
                'main_table.entity_id = newpart.entity_id',
                ['new_created_date' => 'newpart.created_date']
            )
            ->joinLeft(
                ['discontinuepart' => $this->getTable('ccc_filetransfer/distable')],
                'main_table.entity_id = discontinuepart.entity_id',
                ['discontinue_created_date' => 'discontinuepart.created_date']
            )
            ->columns(new Zend_Db_Expr("
                CASE
                    WHEN discontinuepart.entity_id IS NOT NULL THEN 'discontinue'
                    WHEN newpart.entity_id IS NOT NULL THEN 'new'
                    ELSE 'regular'
                END AS status
            "));
        return $this;
    }
}
