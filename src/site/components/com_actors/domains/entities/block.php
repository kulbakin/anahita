<?php
/**
 * Block edge represents a block operation
 * 
 * @category   Anahita
 * @package    Com_Actors
 * @subpackage Domain_Entity
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComActorsDomainEntityBlock extends ComBaseDomainEntityEdge
{
    /**
    * Initializes the default configuration for the object
    *
    * Called from {@link __construct()} as a first step of object instantiation.
    *
    * @param KConfig $config An optional KConfig object with configuration options.
    *
    * @return void
    */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'relationships' => array(
                'blocker' => array('parent' => 'com:actors.domain.entity.actor'),
                'blocked' => array('parent' => 'com:actors.domain.entity.actor'),
            ),
            'aliases' => array(
                'blocker' => 'nodeA',
                'blocked' => 'nodeB',
            )
        ));
        
        parent::_initialize($config);
    }
}
