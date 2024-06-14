<?php
class Ccc_Filetransfer_Model_Resource_Ftp extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_filetransfer/ftpfile', 'ftp_id');
    }
    
}
