<?php
/**
 * Comment Authorizer
 * 
 * @category   Anahita
 * @package    Com_Medium
 * @subpackage Domain_Authorizer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComNotesDomainAuthorizerComment extends ComMediumDomainAuthorizerDefault
{
    /**
     * Notes comment can not be edited
     * 
     * @param  KCommandContext $context
     * @return boolean
     */
    protected function _authorizeEdit($context)
    {
        return false;
    }
}
