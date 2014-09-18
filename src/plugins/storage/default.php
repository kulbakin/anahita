<?php
/**
 * Default Storage Plugin 
 * 
 * @category   Anahita
 * @package    Plg_Storage
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class PlgStorageDefault extends KObject implements KServiceInstantiatable
{
    /**
     * Force creation of a singleton
     * 
     * @param KConfigInterface  $config    An optional KConfig object with configuration options
     * @param KServiceInterface $container A KServiceInterface object
     * @return KServiceInstantiatable
     */
    public static function getInstance(KConfigInterface $config, KServiceInterface $container)
    {
        JPluginHelper::importPlugin('storage');
        
        if ( ! $container->has($config->service_identifier)) {
            $classname = $config->service_identifier->classname;
            $instance  = new PlgStorageLocal($config);
            $container->set($config->service_identifier, $instance);
        }
        
        return $container->get($config->service_identifier);
    }
}
