<?php
class Ccc_Filetransfer_Block_Adminhtml_Ftpconfiguration extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'ccc_filetransfer';
        $this->_controller = 'adminhtml_ftpconfiguration';
        $this->_headerText = Mage::helper('ccc_filetransfer')->__('Manage FTP Configurations');
        parent::__construct();
    }

}
