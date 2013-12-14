<?php

/**
 * Default Authorizer
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Domain_Authorizer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3
 */
class LibBaseDomainAuthorizerDefault extends LibBaseDomainAuthorizerAbstract 
{
    /**
     * Check if a node authroize being subscribed too
     * 
     * @param KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeSubscribe($context)
    {
        $entity = $this->_entity;
        
        if ($this->_viewer->guest()) {
            return false;
        }
        
        if ( ! $entity->isSubscribable()) {
            return false;
        }
        
        // if already subscribed to the node then return false
        if ($entity->subscribed($this->_viewer)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Check if a node authroize being voted
     * 
     * @param KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeVote($context)
    {
        if ($this->_viewer->guest()) {
            return false;
        }
        
        return $this->_entity->isVotable();
    }
    
    /**
     * Checks if a comment can be added to a  node
     * 
     * @param KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeAddComment($context)
    {
        if ($this->_viewer->guest()) {
            return false;
        }
        
        if ($this->_entity->isCommentable()) {
            if (is_person($this->_viewer) && $this->_viewer->admin()) {
                return true;
            }
            
            if ( ! $this->_entity->openToComment) {
                return false;
            }
            
            if ($this->_entity->isOwnable()) {
                // if ownable and can't access the owner then can't comment
                if ($this->_entity->owner->authorize('access') === false) {
                    return false;
                }
                
                $action  = 'com_'.$this->_entity->getIdentifier()->package.':'.$this->_entity->getIdentifier()->name.':addcomment';
                $result  = $this->_entity->owner->authorize('action',array('action'=>$action));
                if ($result === false) {
                    /**
                     * @TODO We need to communicate back the nature of not having a 
                     * permission to comment on an entity.Right now we are using
                     * the entity iself as the communication mechanism. Perpas an error
                     * object to KCommandContext
                     */
                    $this->_entity->__require_follow = false;
                    if ($this->_entity->owner->hasPermission($action, LibBaseDomainBehaviorPrivatable::FOLLOWER)) {
                        $this->_entity->__require_follow = true;
                    }
                }
                return $result;
            }
        }
        
        return  false;
    }
}