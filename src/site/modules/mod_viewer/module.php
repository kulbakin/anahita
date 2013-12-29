<?php
/**
 * Module Controller
 * 
 * @category   Anahita
 * @package    Mod_Viewer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ModViewerModule extends ModBaseModule
{
    /**
     * (non-PHPdoc)
     * @see ModBaseModule::_actionDisplay()
     */
    protected function _actionDisplay()
    {
        if ( ! get_viewer()->guest()) {
            $this->return = base64_encode(JURI::base());
        } else {
            $this->getView()->layout('login');
        }
        return parent::_actionDisplay();
    }
}
