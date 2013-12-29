<?php
/**
 * Privatable Behavior
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Controller_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2011 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComBaseControllerBehaviorPrivatable extends KControllerBehaviorAbstract
{    
    /**
     * Set a privacy for a privatable entity 
     * 
     * @param KCommandContext $context Context parameter
     * @return void
     */
    public function _actionSetPrivacy(KCommandContext $context)
    {
        $data  = $context->data;
        $names = KConfig::unbox($data->privacy_name);
        settype($names, 'array');
        foreach ($names as $name) {
            $this->getItem()->setPermission($name, $data->$name);
        }
    }
}
