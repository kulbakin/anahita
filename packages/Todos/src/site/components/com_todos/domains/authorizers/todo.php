<?php

/**
 * Todo Authorizer
 * 
 * @category   Anahita
 * @package    Com_Todos
 * @subpackage Domain
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3
 */
class ComTodosDomainAuthorizerTodo extends ComMediumDomainAuthorizerDefault
{
    /**
     * Check if a node authorize being updated
     * 
     * @param KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeEdit($context)
    {
        $ret = parent::_authorizeEdit($context);
        
        if ($ret === false) {
            if ($this->_entity->isOwnable()) {
                $action  = $this->_entity->component.':'.$this->_entity->getIdentifier()->name.':add';
                
                if ($this->_entity->owner->authorize('action', $action)) {
                    return true;
                }
            }
        }
        
        return $ret;
    }
}
