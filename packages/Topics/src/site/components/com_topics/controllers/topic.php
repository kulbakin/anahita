<?php
/**
 * Topics Controller
 *
 * @category   Anahita
 * @package    Com_Topics
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComTopicsControllerTopic extends ComMediumControllerDefault
{
    /**
     * Browse Topics
     * 
     * @param KCommandContext $context Context
     * @return void
     */
    protected function _actionBrowse($context)
    {
        $topics = parent::_actionBrowse($context);
        
        if ($this->filter != 'leaders') {
            $topics->order('isSticky', 'desc');
        }
        
        $topics->order('IF(@col(lastCommentTime) IS NULL, @col(creationTime), @col(lastCommentTime))', 'desc');
    }
    
    /**
     * When a topic is added, then create a notification
     * 
     * @param KCommandContext $context Context parameter
     * @return void
     */
    protected function _actionAdd($context)
    {
        $entity = parent::_actionAdd($context);
        if ($entity->owner->isSubscribable()) {
            $notification = $this->createNotification(array(
                'name'        => 'topic_add',
                'object'      => $entity,
                'subscribers' => $entity->owner->subscriberIds->toArray(),
            ))->setType('post', array('new_post' => true));
        }
        
        return $entity;
    }
    
    /**
     * Sticks/unstick a topic
     * 
     * @param  KCommandContext $context Context parameter
     * @return void
     */
    protected function _actionSticky($context)
    {
        $data = $context->data;
        $this->getItem()->isSticky = $data->is_sticky;
        
    }
}
