<?php
/**
 * Default Permission
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Controller_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2011 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComBaseControllerPermissionDefault extends LibBaseControllerPermissionDefault
{
    /**
     * Generic authorize handler for controller add actions
     * 
     * @return boolean Can return both true or false.
     */
    public function canAdd()
    {
        $result = false;
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $result = JFactory::getUser()->authorise('core.create') === true;
        } else {
            $result = JFactory::getUser()->get('gid') > 22;
        }
        
        return $result;
    }
    
    /**
     * Generic authorize handler for controller edit actions
     *
     * @return boolean Can return both true or false.
     */
    public function canEdit()
    {
        $result = false;
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $result = JFactory::getUser()->authorise('core.edit') === true;
        } else {
            $result = JFactory::getUser()->get('gid') > 22;
        }
        
        return $result;
    }
    
    /**
     * Generic authorize handler for controller delete actions
     * 
     * @return boolean Can return both true or false.
     */
    public function canDelete()
    {
        $result = false;
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $result = JFactory::getUser()->authorise('core.delete') === true;
        } else {
            $result = JFactory::getUser()->get('gid') > 22;
        }
        
        return $result;
    }
}
