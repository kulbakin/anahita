<?php

/**
 * Story Authorizer
 * 
 * @category   Anahita
 * @package    Com_Stories
 * @subpackage Domain_Authorizer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComStoriesDomainAuthorizerStory extends LibBaseDomainAuthorizerDefault
{
    /**
     * Check if a node authorize being updated
     * 
     * @param  KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeDelete($context)
    {
        $owneids = $this->_entity->getIds('owner');
        
        if (count($owneids) > 1) {
            return false;
        } elseif ($this->_viewer->admin()) {
            return true;
        } elseif ($this->_entity->owner->authorize('administration', $context)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Checks if a comment can be added to a story
     * 
     * @param  KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeAddComment($context)
    {
        return $this->_deligate($this->object, 'add.comment', $context);
    }
    
    /**
     * Authoriz vote 
     *
     * @param KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeVote($context)
    {
        return $this->_deligate($this->object, 'vote', $context);
    }
    
    /**
     * Authoriz deleting a comment 
     *
     * @param KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeDeleteComment($context)
    {
        return $this->_deligate($this->object, 'delete.comment', $context);
    }
    
    /**
     * Checks if a comment of a  node can be edited
     * 
     * @param  KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeEditComment($context)
    {
        return $this->_deligate($this->object, 'edit.comment', $context);
    }
}
