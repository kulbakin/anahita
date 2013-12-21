<?php
/**
 * Actorbar. 
 * 
 * @category   Anahita
 * @package    Com_Pages
 * @subpackage Controller_Toolbar
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPagesControllerToolbarActorbar extends ComMediumControllerToolbarActorbar
{
    /**
     * Before controller action
     * 
     * @param  KEvent $event Event object 
     * @return string
     */
    public function onBeforeControllerGet(KEvent $event)
    {
        parent::onBeforeControllerGet($event);
        
        $actor  = pick($this->getController()->actor, get_viewer());
        $name   = $this->getController()->getIdentifier()->name;
        
        if ($this->getController()->filter == 'leaders') {
            $this->setTitle(JText::_('COM-PAGES-ACTOR-HEADER-PAGES-LEADERS'));
            $this->setDescription(JText::_('COM-PAGES-ACTOR-HEADER-PAGES-LEADERS-DESCRIPTION'));
        } else {
            $this->setTitle(JText::sprintf('COM-PAGES-ACTOR-HEADER-'.strtoupper($name).'S', $actor->name));
            
            //create navigations
            $this->addNavigation(
                'pages',
                JText::_('COM-PAGES-LINK-PAGES'),
                array('option' => 'com_pages', 'view' => 'pages', 'oid' => $actor->id),
                $name == 'page'
           );
        }
    }
}
