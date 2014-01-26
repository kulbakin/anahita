<?php
/**
 * Enableable Behavior
 * 
 * @category   Anahita
 * @package    Com_Medium
 * @subpackage Domain_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComMediumDomainBehaviorEnableable extends LibBaseDomainBehaviorEnableable
{
    /**
     * Only brings the media that are enabled or disabled but the viewer or one
     * of the actor they are administrating the owner
     * 
     * @param KCommandContext $context Context Parameter
     * @return void
     */
    protected function _beforeRepositoryFetch(KCommandContext $context)
    {
        $query = $context->query;
        $repos = $query->getRepository();
        if ($repos->hasBehavior('ownable')) {
            if ( ! get_viewer()->admin()) {
                $ids   = get_viewer()->administratingIds->toArray();
                $ids[] = get_viewer()->id;
                $ids   = implode(',', $ids);
                $query->where("IF(@col(enabled) = FALSE, @col(owner.id) IN ($ids), 1)");
            }
        }
    }
}
