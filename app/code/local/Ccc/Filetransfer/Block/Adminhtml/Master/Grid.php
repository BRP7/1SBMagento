<?php
class Ccc_Filetransfer_Block_Adminhtml_Master_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_filetransfer/master')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Entity Id'),
                'id'=> 'entity_id',
                'align' => 'center',
                'width' => '200px',
                'index' => 'entity_id',
            )
        );
        $this->addColumn(
            'part_no',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Port Number'),
                'id'=> 'part_no',
                'align' => 'center',
                'width' => '200px',
                'index' => 'part_no',
            )
        );
       
        $this->addColumn(
            'updated_date',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Updated Date'),
                'align' => 'center',
                'width' => '100px',
                'index' => 'updated_date',
            )
        );
        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Status'),
                'align' => 'center',
                'width' => '100px',
                'index' => 'status',
            )
        );
        return parent::_prepareColumns();
    }
   
}
