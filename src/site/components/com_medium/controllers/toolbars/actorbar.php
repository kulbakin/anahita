<?php
/**
 * Medium Controller Actorbar
 * 
 * @category   Anahita
 * @package    Com_Medium
 * @subpackage Controller_Toolbar
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComMediumControllerToolbarActorbar extends ComBaseControllerToolbarActorbar
{
    /**
     * Before Controller _actionRead is executed
     * 
     * @param KEvent $event
     * @return void
     */
    public function onBeforeControllerGet(KEvent $event)
    {
       if ($this->getController()->isOwnable() && ! $this->getController()->actor) {
            $this->setActor(get_viewer());
       }
       
       parent::onBeforeControllerGet($event);
    }
}
