<?php

class Practice_Exam_Model_Resource_Exam extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('practice_exam/exam', 'exam_id');
    }
}
