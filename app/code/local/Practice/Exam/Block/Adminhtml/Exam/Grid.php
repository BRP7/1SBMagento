<?php

class Practice_Exam_Block_Adminhtml_Exam_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('exam');
        $this->setDefaultSort('exam_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('practice_exam/exam')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    
    protected function _prepareColumns()
    {
        $this->addColumn('exam_id', array(
            'header' => Mage::helper('practice_exam')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'exam_id',
        ));

        $this->addColumn('grid_name', array(
            'header' => Mage::helper('practice_exam')->__('Grid Name'),
            'align' => 'left',
            'index' => 'grid_name',
        ));

        $this->addColumn('show_on', array(
            'header' => Mage::helper('practice_exam')->__('Show On'),
            'align' => 'left',
            'index' => 'show_on',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('practice_exam')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => Mage::helper('practice_exam')->__('Enabled'),
                2 => Mage::helper('practice_exam')->__('Disabled'),
            ),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('practice_exam')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('practice_exam')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));
        if (!Mage::getSingleton('admin/session')->isAllowed('practice_exam/exam/edit')) {
            $this->removeColumn('action');
        }
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('exam_id');
        $this->getMassactionBlock()->setFormFieldName('exam');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('practice_exam')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('practice_exam')->__('Are you sure?')
        ));

        $statuses = array(
            1 => Mage::helper('practice_exam')->__('Enabled'),
            2 => Mage::helper('practice_exam')->__('Disabled')
        );

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('practice_exam')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('practice_exam')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('practice_exam/exam/edit')) {
            return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        }
        return false;
    }
}
