<?php
class Ccc_Filetransfer_Block_Adminhtml_Ftpfile_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_filetransfer/ftp')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'file_name',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('File Name'),
                'id'=> 'file_name',
                'align' => 'center',
                'width' => '200px',
                'index' => 'file_name',
            )
        );
        $this->addColumn(
            'file_path',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('File Path'),
                'id'=> 'file_path',
                'align' => 'center',
                'width' => '200px',
                'index' => 'file_path',
            )
        );
       
        $this->addColumn(
            'configuration_id',
            array(
                'header' => Mage::helper('ccc_filetransfer')->__('Configuraton Id'),
                'align' => 'center',
                'width' => '100px',
                'index' => 'configuration_id',
            )
        );
        $this->addColumn('action', [
            'header' => Mage::helper('ccc_filetransfer')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'renderer' => 'Ccc_Filetransfer_Block_Adminhtml_FtpFile_Grid_Renderer_Action',
            'filter' => false,
            'sortable' => false,
            'is_system' => true,
        ]);
        return parent::_prepareColumns();
    }
   
}
