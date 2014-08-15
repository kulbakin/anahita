<?php
/**
 * Toolbar Helper
 *
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Template_Helper
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComBaseTemplateHelperToolbar extends KTemplateHelperAbstract
{
    /**
     * Return a container of commands by calling add[Name]Commands on the toolbar
     * object. If the toolbar is not set then 
     * 
     * @param string $name   The command set name
     * @param array  $data   Data pass to the controller toolbar 
     * @return LibBaseTemplateObjectContainer
     */
    public function commands($name, $data = array())
    {
        $toolbar = $this->_template->getHelper('controller')->getToolbar();
        
        if ( ! empty($data['clone'])) {
            $toolbar = clone $toolbar;
        }
        
        if ($toolbar instanceof KControllerToolbarAbstract) {
            //reset the toolbar
            $toolbar->reset();
            $method  = 'add'.ucfirst($name).'Commands';
            if (method_exists($toolbar, $method)) {
                $toolbar->$method();
            }
            
            return $toolbar->getCommands();
        }
    }
}
