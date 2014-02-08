<?php
/**
 * Module Controller
 * 
 * @category   Anahita
 * @package    Mod_Menu
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ModMenuModule extends ModBaseModule
{
    /**
     * (non-PHPdoc)
     * @see LibBaseControllerAbstract::__set()
     */
    public function __set($key, $value)
    {
        if ($key == 'menutype') {
            $this->getState()->setList(JSite::getMenu()->getItems('menutype', $value));
        }
        
        return parent::__set($key, $value);
    }
}
