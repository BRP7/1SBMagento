<?php

class Ccc_Ticketsystem_Block_Adminhtml_Viewcommentreply extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/comment_reply_system.phtml');
        $this->getCommentIds();
    }

    // public function getComments()
    // {
    //     $id = $this->getRequest()->getParam('id');
    //     $collection = Mage::getModel('ccc_ticketsystem/comment')->getCollection()->addFieldToFilter('ticket_id', $id);

    //     $comments = [];
    //     foreach ($collection as $comment) {
    //         $parentId = $comment->getParentId();
    //         if (!isset($comments[$parentId])) {
    //             $comments[$parentId] = [];
    //         }
    //         $comments[$parentId][] = $comment;
    //     }
    //     // echo "<pre>";
    //     // print_r($comments);
    //     return $comments;
    // }
    // public function getCommentIds()
    // {
    //     $id = $this->getRequest()->getParam('id');
    //     $collection = Mage::getModel('ccc_ticketsystem/comment')->getCollection()->addFieldToFilter('ticket_id', $id);

    //     $comments = [];
    //     foreach ($collection as $comment) {
    //         $parentId = $comment->getParentId();
    //         if (!isset($comments[$parentId])) {
    //             $comments[$parentId] = [];
    //         }
    //         $comments[$parentId][] = $comment->getId();
    //     }
    //     print_r($comments);
    //     return $comments;
    // }
   

    // public function renderComments($comments, $parentId)
    // {
    //     if (!isset($comments[$parentId])) {
    //         return '';
    //     }
    
    //     $html = '';
    //     foreach ($comments[$parentId] as $comment) {
    //         $commentId = $comment->getId();
    //         $html .= '<tr class="comment" data-ticket-id="' . $comment->getTicketId() . '" data-comment-id="' . $commentId . '" data-parent-id="' . $comment->getParentId() . '">';
    //         $html .= '<td>';
    //         $html .= '<div class="comment-content">';
    //         $html .= '<div>' . htmlspecialchars_decode($comment->getDescription()) . '</div>';
            

    //         if ($comment->getParentId() == 0) {
    //             $html .= '<button class="lock">Lock</button>';
    //         } 
    //         $html .= '<button class="add-new">Add New</button>';
    //         $html .= '</div>';
    //         $html .= '<table class="children">';
    //         $html .= $this->renderComments($comments, $commentId);
    //         $html .= '</table>';
    //         $html .= '</td>';
    //         $html .= '</tr>';
    //     }
    
    //     return $html;
    // }

    protected $_level = 0;
  
    public function getComments()
    {
        $ticketId = $this->getRequest()->getParam('id');
        $comments = Mage::getModel('ccc_ticketsystem/comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $ticketId)
            ->getData();
        return $this->prepareCommentArray($comments);
    }
    // public function getComments()
    // {
    //     $ticketId = $this->getRequest()->getParam('id');
    //     $comments = Mage::getModel('ccc_ticketsystem/comment')
    //         ->getCollection()
    //         ->addFieldToFilter('ticket_id', $ticketId)
    //         // ->getData();
    //         ->addFieldToFilter('parent_id',0);
    //     return $comments;
    // }
    public function prepareCommentArray($comments, $parentId = 0, &$rowspan = 0)
    {
        $commentArr = [];
        foreach ($comments as $_comment) {
            if ($_comment['level'] > $this->_level) {
                $this->_level = $_comment['level'];
            }
            if ($_comment['parent_id'] == $parentId) {
                $childRowspan = 0;
                $childComment = $this->prepareCommentArray($comments, $_comment['comment_id'], $childRowspan);
                if ($childComment) {
                    $_comment['childArr'] = $childComment;
                    $_comment['rowspan'] = $childRowspan;
                } else {
                    $_comment['rowspan'] = 1;
                }

                $rowspan += $_comment['rowspan'];
                $commentArr[] = $_comment;
            }
        }

        return $commentArr;
    }
    public function getHtml($comments)
    {
        // echo '<pre>';
        // print_r($comments);
        $html = '<table data-ticket-id="' . $this->getRequest()->getParam('id') . '"
                data-level="' . $this->_level . '"
                class="commentTable"  border="1">';
        $html .= $this->generateTableRows($comments);
        $html .= '</table>';
        return $html;
    }
    private function generateTableRows($comments, $level = 0)
    {
        $html = '';
        foreach ($comments as $comment) {
            if ($level == 0) {
                $html .= '<tr>';
            }
            $html .= '<td rowspan="' . $comment['rowspan'] .
                '" data-comment-id="' . $comment['comment_id'] . '"
                data-parent-id="' . $comment['parent_id'] .
                '" data-level="' . $comment['level'] . '">' . $comment['description'];

            if ($comment['completed'] == 0) {
                if ($comment['status'] == 2) {
                    $html .= '<button class="button" onclick="commentBoxObj.addNewRow(this)">Reply</button>';
                    if (empty($comment['childArr'])) {
                        $html .= '<button class="button" onclick="commentBoxObj.completeRow(this)">complete</button>';
                    }
                    $html .= '</tr></td>';
                }
                if (!empty($comment['childArr'])) {
                    $html .= $this->generateTableRows($comment['childArr'], $level + 1);
                    $html .= '</td>';
                } else {
                    $html .= '</tr>';
                }
            } else if ($comment['completed'] == 1) {
                $html .= 'completed';
                $html .= '</td>';
                continue;
            }
        }
        return $html;
    }
}


    

