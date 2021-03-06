<?php
/**
 * Abstract Authorizer class.
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Domain_Authorizer
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
abstract class LibBaseDomainAuthorizerAbstract extends KObject
{
    /**
     * Viewer
     * 
     * @var ComPeopleDomainEntityPerson
     */
    protected $_viewer;
    
    /**
     * The authorizing object
     * 
     * @var AnDomainEntityAbstract
     */
    protected $_entity;
    
    /**
     * Authorization Constants. If AUTH_NOT_IMPLEMENTED is returned then
     * chain will continue its search
     */
    const AUTH_PASSED = true;
    const AUTH_FAILED = false;
    const AUTH_NOT_IMPLEMENTED = -9999;
    
    /**
     * Deligate authorization to another object
     * 
     * @param mixed $object
     * @param string $action
     * @param KCommandContext|array[optional] $context
     * @return bool
     */
    protected function _deligate($object, $action, $context = array(), $fallback = self::AUTH_FAILED)
    {
        if ($object instanceof KObject && $object->isAuthorizer()) {
            $ret = $object->authorize($action, $context);
            if ($ret !== self::AUTH_NOT_IMPLEMENTED) {
                return $ret;
            }
        }
        
        return $fallback;
    }
    
    /**
     * Executes an authorization action with the passed arguments
     * 
     * @param string          $name    The command name
     * @param KCommandContext $context The command context
     * @return boolean Can return both true or false.  
     */
    final public function execute($action, KCommandContext $context)
    {
        $method = '_'.KInflector::variablize('authorize.'.$action);
        $result = self::AUTH_NOT_IMPLEMENTED;
        
        if (method_exists($this, $method)) {
            $this->_entity = $context->mixer;
            $this->_viewer = $context->viewer;
            $result = $this->$method($context);
        }
        
        return $result;
    }
}
