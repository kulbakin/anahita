<?php
/**
 * Person Toolbar
 * 
 * @category   Anahita
 * @package    Com_People
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPeopleControllerToolbarPerson extends ComActorsControllerToolbarDefault
{
    /**
     * Removes the New command from the toolbar
     * 
     * (non-PHPdoc)
     * @see ComActorsControllerToolbarDefault::onAfterControllerBrowse()
     */
    public function onAfterControllerBrowse(KEvent $event)
    {
    }
}
