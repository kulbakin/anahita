<?php
/**
 * Component object
 * 
 * @category   Anahita
 * @package    Lib_Components
 * @subpackage Domain_Entity
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class LibComponentsDomainEntityComponent extends AnDomainEntityDefault
{
    /**
     * Initializes the default configuration for the object
     * 
     * Called from {@link __construct()} as a first step of object instantiation.
     * 
     * @param KConfig $config An optional KConfig object with configuration options.
     * @return void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'resources' => array('components'),
            'attributes' => array(
                'params'  => array('required' => false, 'default' => ''),
                'enabled' => array(),
            ),
            'behaviors' => to_hash(array(
                'orderable',
                'authorizer',
            )),
            'query_options' => array('where' => array('parent' => 0)),
            'aliases' => array(
                'component' => 'option',
             ),
            'auto_generate' => true,
        ));
        
        return parent::_initialize($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        if ($key == 'name') {
            return ucfirst(str_replace('com_','',$this->option));
        }
        
        return parent::__get($key);
    }
}
