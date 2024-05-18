<?php

class Practice_Jscustomgrid_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('custom_attribute');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('yourmodule')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('yourmodule')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('custom_attribute', array(
            'header'    => Mage::helper('yourmodule')->__('Custom Attribute'),
            'align'     => 'left',
            'index'     => 'custom_attribute',
            'editable'  => true,
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        return $this;
    }
}
