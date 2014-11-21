<?php
/**
 * An ownable node by an actor is a node that can have one main owner
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Domain_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
 class ComBaseDomainBehaviorOwnable extends AnDomainBehaviorAbstract
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
            'relationships' => array(
                'owner' => array(
                    'polymorphic' => true,
                    'required'    => true,
                    'parent'      => 'com:actors.domain.entity.actor',
                    'inverse'     => true,
                )
            )
        ));
        
        parent::_initialize($config);
    }
    
    /**
     * Set the owner of the object. If multiple owners are passed then the first owner is the 
     * primary owner and the rest just share the object with the owner
     * 
     * @param ComActorsDomainEntityActor $owner The owner object
     * @return ComBaseDomainEntityNode Return the ownable object
     */
    public function setOwner($owner)
    {
        // multiple owners are passed
        $owner = KConfig::unbox($owner);
        
        if (is_array($owner)) {
            deprecated('array as owner');
        }
        
        $this->_mixer->set('owner', $owner);
        
        return $this;
    }
}
 