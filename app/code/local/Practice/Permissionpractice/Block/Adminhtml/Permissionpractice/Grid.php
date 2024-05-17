<?php

class Practice_Permissionpractice_Block_Adminhtml_Permissionpractice_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('permissionpractice');
        $this->setDefaultSort('permissionpractice_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('practice_permissionpractice/permissionpractice')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    
    protected function _prepareColumns()
    {
        $this->addColumn('permissionpractice_id', array(
            'header' => Mage::helper('practice_permissionpractice')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'permissionpractice_id',
        ));

        $this->addColumn('grid_name', array(
            'header' => Mage::helper('practice_permissionpractice')->__('Grid Name'),
            'align' => 'left',
            'index' => 'grid_name',
        ));

        $this->addColumn('show_on', array(
            'header' => Mage::helper('practice_permissionpractice')->__('Show On'),
            'align' => 'left',
            'index' => 'show_on',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('practice_permissionpractice')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => Mage::helper('practice_permissionpractice')->__('Enabled'),
                2 => Mage::helper('practice_permissionpractice')->__('Disabled'),
            ),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('practice_permissionpractice')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('practice_permissionpractice')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));
        if (!Mage::getSingleton('admin/session')->isAllowed('practice_permissionpractice/permissionpractice/edit')) {
            $this->removeColumn('action');
        }
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('permissionpractice_id');
        $this->getMassactionBlock()->setFormFieldName('permissionpractice');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('practice_permissionpractice')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('practice_permissionpractice')->__('Are you sure?')
        ));

        $statuses = array(
            1 => Mage::helper('practice_permissionpractice')->__('Enabled'),
            2 => Mage::helper('practice_permissionpractice')->__('Disabled')
        );

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('practice_permissionpractice')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('practice_permissionpractice')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('practice_permissionpractice/permissionpractice/edit')) {
            return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        }
        return false;
    }
}
