
<?php


class Practice_Exam_Model_Resource_Exam_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('practice_exam/exam');
    }
}
