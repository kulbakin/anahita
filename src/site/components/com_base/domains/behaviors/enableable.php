<?php
/**
 * Enabable Behavior
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Domain_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
 class ComBaseDomainBehaviorEnableable extends LibBaseDomainBehaviorEnableable
 {
    /**
     * Only brings the entities that are enabled
     * 
     * @param KCommandContext $context Context Parameter
     * @return void
     */
    protected function _beforeRepositoryFetch(KCommandContext $context)
    {
        $context->query->where('IF(@col(enabled)=FALSE,0,1)');
    }
 }