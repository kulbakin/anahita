<?php

/**
 * Page Authorizer
 * 
 * @category   Anahita
 * @package    Com_Pages
 * @subpackage Domain_Authorizer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPagesDomainAuthorizerPage extends ComMediumDomainAuthorizerDefault
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
                if ($this->_entity->owner->allows($this->_viewer, 'com_pages:page:edit')) {
                    return true;
                }
            }
        }
        
        return $ret;
    }
}
