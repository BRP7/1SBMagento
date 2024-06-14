<?php
class Ccc_Filetransfer_Block_Adminhtml_Ftpconfiguration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_filetransfer/configuration')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'username',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Username'),
                'id'=> 'username',
                'align' => 'center',
                'width' => '200px',
                'index' => 'username',
            )
        );
        $this->addColumn(
            'port',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Port'),
                'id'=> 'port',
                'align' => 'center',
                'width' => '200px',
                'index' => 'port',
            )
        );
        $this->addColumn(
            'host',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Host'),
                'align' => 'center',
                'width' => '100px',
                'index' => 'host',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('is_active'),
                'align' => 'center',
                'index' => 'is_active',
                'width' => '100px',
                'type' => 'options',
                'options' => array(
                    1 => Mage::helper('ccc_filetransfer')->__('Yes'),
                    0 => Mage::helper('ccc_filetransfer')->__('No')
                ),
            )
        );
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('configuration_id' => $row->getId()));
    }
}
