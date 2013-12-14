<?php
/**
 * Enabable Behavior
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Domain_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3
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