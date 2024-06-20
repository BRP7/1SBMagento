<?php


class Ccc_Ticketsystem_Block_Adminhtml_Viewcommentreply extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/comment_reply_system.phtml');
    }

    public function getComments()
    {
        $id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('ccc_ticketsystem/comment')->getCollection()->addFieldToFilter('ticket_id', $id);

        $comments = [];
        foreach ($collection as $comment) {
            $parentId = $comment->getParentId();
            if (!isset($comments[$parentId])) {
                $comments[$parentId] = [];
            }
            $comments[$parentId][] = $comment;
        }
        return $comments;
    }

    public function renderComments($comments, $parentId)
    {
        if (!isset($comments[$parentId])) {
            return '';
        }

        $html = '';
        foreach ($comments[$parentId] as $comment) {
            $commentId = $comment->getId();
            $html .= '<tr class="comment" data-ticket-id="' . $comment->getTicketId() . '" data-comment-id="' . $commentId . '" data-parent-id="' . $comment->getParentId() . '">';
            $html .= '<td>';
            $html .= '<div class="comment-content">';
            $html .= '<div>' . htmlspecialchars_decode($comment->getDescription()) . '</div>';
            $html .= '<button class="add-new">Add New</button>';
            $html .= '</div>';
            $html .= '<table class="children">';
            $html .= $this->renderComments($comments, $commentId);
            $html .= '</table>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        return $html;
    }
}
