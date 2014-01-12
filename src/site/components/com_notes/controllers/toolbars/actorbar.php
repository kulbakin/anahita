<?php
/**
 * Actorbar.
 * 
 * @category   Anahita
 * @package    Com_Notes
 * @subpackage Controller_Toolbar
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComNotesControllerToolbarActorbar extends ComBaseControllerToolbarActorbar
{
    /**
     * Before _actionGet controller event
     * 
     * @param  KEvent $event Event object 
     * @return string
     */
    public function onBeforeControllerGet(KEvent $event)
    {
        parent::onBeforeControllerGet($event);
        
        $actor  = pick($this->getController()->actor, get_viewer());
        
        if ($this->getController()->filter == 'leaders') {
            $this->setTitle(JText::_('COM-NOTES-ACTOR-HEADER-NOTES-LEADERS'));
            $this->setDescription(JText::_('COM-NOTES-ACTOR-HEADER-NOTES-LEADERS-DESCRIPTION'));
        } else {
            $this->setTitle(JText::sprintf('COM-NOTES-HEADER-NOTES', $actor->name));
            
            //create navigations
            $this->addNavigation(
                'notes',
                JText::_('COM-NOTES-LINK-NOTES'),
                array('option' => 'com_notes', 'view' => 'notes', 'oid' => $actor->id),
                true
           );
        }
    }
}
