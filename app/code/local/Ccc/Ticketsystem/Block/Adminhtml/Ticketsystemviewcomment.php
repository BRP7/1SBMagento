<?php
class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystemviewcomment extends Mage_Adminhtml_Block_Template
{
    public function _construct()
    {
        $this->setTemplate('ticketsystem/ticket_comment.phtml');
    }

    public function getComments()
    {
        $ticketId = $this->getRequest()->getParam('id');
        $comments = Mage::getModel('ccc_ticketsystem/comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $ticketId)
            ->setOrder('created_at', 'ASC'); // Order by oldest first to nest correctly
        return $comments;
    }

    public function getNestedComments($comments, $parentId = 0)
    {
        $nestedComments = [];
        foreach ($comments as $comment) {
            if ($comment->getParentId() == $parentId) {
                $children = $this->getNestedComments($comments, $comment->getId());
                if ($children) {
                    $comment->setChildren($children);
                }
                $nestedComments[] = $comment;
            }
        }
        return $nestedComments;
    }

    public function renderComment($comment, $level = 0)
    {
        $html = '<tr style="margin-left: ' . ($level * 20) . 'px;">';
        $html .= '<td>' . $comment->getTitle() . '</td>';
        $html .= '<td>' . htmlspecialchars_decode($comment->getDescription(), ENT_QUOTES) . '</td>';
        $html .= '<td>' . $comment->getCreatedAt() . '</td>';
        $html .= '</tr>';

        if ($comment->getChildren()) {
            foreach ($comment->getChildren() as $child) {
                $html .= $this->renderComment($child, $level + 1);
            }
        }
        return $html;
    }
}
