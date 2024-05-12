<?php

class Practice_Customgrid_Block_Adminhtml_Customgrid_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customgridGrid');
        $this->setDefaultSort('customgrid_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('practice_customgrid/customgrid')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('customgrid_id', array(
            'header' => Mage::helper('practice_customgrid')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'customgrid_id',
        ));

        $this->addColumn('grid_name', array(
            'header' => Mage::helper('practice_customgrid')->__('Grid Name'),
            'align' => 'left',
            'index' => 'grid_name',
        ));

        $this->addColumn('show_on', array(
            'header' => Mage::helper('practice_customgrid')->__('Show On'),
            'align' => 'left',
            'index' => 'show_on',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('practice_customgrid')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => Mage::helper('practice_customgrid')->__('Enabled'),
                2 => Mage::helper('practice_customgrid')->__('Disabled'),
            ),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('practice_customgrid')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('practice_customgrid')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('customgrid_id');
        $this->getMassactionBlock()->setFormFieldName('customgrid');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('practice_customgrid')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('practice_customgrid')->__('Are you sure?')
        ));

        $statuses = array(
            1 => Mage::helper('practice_customgrid')->__('Enabled'),
            2 => Mage::helper('practice_customgrid')->__('Disabled')
        );

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('practice_customgrid')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('practice_customgrid')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
