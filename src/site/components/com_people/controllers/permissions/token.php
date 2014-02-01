<?php
/**
 * Token Permissions
 * 
 * @category   Anahita
 * @package    Com_People
 * @subpackage Controller_Permission
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPeopleControllerPermissionToken extends LibBaseControllerPermissionDefault
{ 
    /**
     * (non-PHPdoc)
     * @see LibBaseControllerPermissionAbstract::canExecute()
     */
    public function canExecute($action)
    {
        return JFactory::getUser()->id == 0;
    }
}
