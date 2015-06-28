<?php
/**
 * Default Comment Authorizer
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Domain_Authorizer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComBaseDomainAuthorizerComment extends LibBaseDomainAuthorizerDefault
{
    /**
     * Checks if a comment can be deleted
     * 
     * @param  KCommandContext $context
     * @return boolean
     */
    protected function _authorizeDelete($context)
    {
        return $this->_deligate($this->_entity->parent, 'delete.comment', array('comment' => $this->_entity) + KConfig::unbox($context));
    }
    
    /**
     * Checks if a comment edited
     * 
     * @param  KCommandContext $context
     * @return boolean
     */
    protected function _authorizeEdit($context)
    {
        return $this->_deligate($this->_entity->parent, 'edit.comment', array('comment' => $this->_entity) + KConfig::unbox($context));
    }
}