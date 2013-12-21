<?php
/**
 * Notes Toolbar
 * 
 * @category   Anahita
 * @package    Com_Notes
 * @subpackage Controller_Toolbar
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComNotesControllerToolbarNote extends ComMediumControllerToolbarDefault
{ 
    /**
     * Set the toolbar commands
     * 
     * @return void
     */
    public function addToolbarCommands()
    {
        parent::addToolbarCommands();
        
        //no need to have comment status for messages
        $this->_commands->extract('commentstatus');
    }
}
