<?php
class Ccc_Locationcheck_Block_Adminhtml_Locationcheck_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

    }
    protected function _prepareCollection()
    {

        $collection = Mage::getModel('ccc_locationcheck/locationcheck')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('locationcheck')->__('Id'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        )
        );

        $this->addColumn('zipcode', array(
            'header' => Mage::helper('locationcheck')->__('Zipcode'),
            'align' => 'left',
            'index' => 'zipcode',
            'type' => 'text',
            'column_css_class' => 'row_name',
        )
        );

        $this->addColumn('is_active', array(
            'header' => Mage::helper('locationcheck')->__('Is Active'),
            'align' => 'left',
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('locationcheck')->__('Yes'),
                '0' => Mage::helper('locationcheck')->__('No'),
            ),
            'column_css_class' => 'is_active',
        )
        );
        $this->addColumn('created_at', array(
            'header' => Mage::helper('locationcheck')->__('Created Date'),
            'align' => 'left',
            'width' => '200px',
            'type' => 'datetime',
            'index' => 'created_at',
            'column_css_class' => 'created_at',
            'renderer' => 'ccc_locationcheck/adminhtml_locationcheck_grid_renderer_datetime',
        ));

        $this->addColumn('updated_at', array(
            'header' => Mage::helper('locationcheck')->__('Updated Date'),
            'align' => 'left',
            'width' => '200px',
            'type' => 'datetime',
            'index' => 'updated_at',
            'column_css_class' => 'updated_at',
            'renderer' => 'ccc_locationcheck/adminhtml_locationcheck_grid_renderer_datetime',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id'); 

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('locationcheck')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('locationcheck')->__('Are you sure you want to delete selected locationcheck?')
            )
        );

        $statuses = Mage::getSingleton('ccc_locationcheck/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'is_active',
            array(
                'label' => Mage::helper('locationcheck')->__('Change Is Active'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'is_active',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('locationcheck')->__('Is Active'),
                        'values' => $statuses
                    )
                )
            )
        );

        Mage::dispatchEvent('locationcheck_adminhtml_locationcheck_grid_prepare_massaction', array('block' => $this));
        return $this;
    }



}
