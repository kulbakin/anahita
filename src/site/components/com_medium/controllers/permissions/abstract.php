<?php
/**
 * Abstract Medium Permission
 * 
 * @category   Anahita
 * @package    Com_Medium
 * @subpackage Controller_Permission
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
abstract class ComMediumControllerPermissionAbstract extends LibBaseControllerPermissionDefault
{
    /**
     * Authorize Browse
     * 
     * @return boolean
     */
    public function canBrowse()
    {
        $viewer = get_viewer();
        
        if ($this->isOwnable() && $this->actor) {
            // a viewer can't see  ownable items coming from another actor's leaders
            if ($this->filter == 'leaders') {
                if ($viewer->id != $this->actor->id) {
                    return false;
                }
            }
        }
        return true;
    }
    
    /**
     * Authorize Read
     * 
     * @return boolean
     */
    public function canRead()
    {
        // if repository is ownable then ask the actor if viewer can publish things
        if (in_array($this->getRequest()->get('layout'), array('add', 'edit', 'form', 'composer'))) {
            if ($this->getItem()) {
                $result = $this->_mixer->canEdit();
            } else {
                $result = $this->_mixer->canAdd();
            }
            return $result;
        }
        
        if ( ! $this->getItem()) {
            return false;
        }
        
        // check if an entiy authorize access
        return $this->getItem()->authorize('access');
    }
    
    /**
     * Authorize if viewer can add
     * 
     * @return boolean
     */
    public function canAdd()
    {
        $actor = $this->actor;
        if ($actor) {
            $action  = 'com_'.$this->_mixer->getIdentifier()->package.':'.$this->_mixer->getIdentifier()->name.':add';
            $ret = $actor->authorize('action', $action);
            return $ret !== false;
        }
        
        return false;
    }
    
    /**
     * Authorize Read
     * 
     * @return boolean
     */
    public function canEdit()
    {
        if ($this->getItem()) {
            return $this->getItem()->authorize('edit');
        }
        
        return false;
    }
    
    /**
     * If an app is not enabled for an actor then don't let the viewer to see it
     * 
     * @param string $action Action name
     * @return boolean
     */
    public function canExecute($action)
    {    
        // check if viewer has access to actor
        if ($this->isOwnable() && $this->actor) {
            if ($this->actor->authorize('access') === false) {
                return false;
            }
        }
        
        return parent::canExecute($action);
    }
}
