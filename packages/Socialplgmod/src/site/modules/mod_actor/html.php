<?php
/**
 * Actor Module
 * 
 * @category   Anahita
 * @package    Mod_Actor
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ModActorHtml extends ModBaseHtml
{
    /**
     * Default Layout
     *
     * @return
     */
    protected function _layoutDefault()
    {
        $this->commands = $commands = new LibBaseTemplateObjectContainer();
        
        $viewer = $this->viewer;
        $actor  = $this->actor;
        
        if ($viewer->following($actor)) {
            $commands->insert('follow', array('label' => JText::_('MOD-ACTOR-ACTION-UNFOLLOW')))
                ->href($actor->getURL().'&action=unfollow')
                ->class('btn')->dataTrigger('Submit');
        } elseif ($actor->authorize('follower') || $viewer->guest()) {
            $commands->insert('follow',array('label' => JText::_('MOD-ACTOR-ACTION-FOLLOW')))
                ->href($actor->getURL().'&action=follow')
                ->class('btn btn-primary')
                ->dataTrigger('Submit');
        }
    }
}
