<?php
/**
 * Note authorizer
 * 
 * @category   Anahita
 * @package    Com_Medium
 * @subpackage Domain_Authorizer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComNotesDomainAuthorizerNote extends ComMediumDomainAuthorizerDefault
{
    /**
     * Notes are not ediable
     * 
     * @param KCommandContext $context Context parameter
     * @return boolean
     */
    protected function _authorizeEdit($context)
    {
        return false;
    }
}