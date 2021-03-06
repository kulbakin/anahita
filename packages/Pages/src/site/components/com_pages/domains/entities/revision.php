<?php
/**
 * Revision Entity
 * 
 * @category   Anahita
 * @package    Com_pages
 * @subpackage Domain_Entity
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPagesDomainEntityRevision extends ComMediumDomainEntityMedium 
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
            'behaviors' => array(
                'parentable' => array('parent' => 'page'),
            ),
            'attributes' => array(
                'excerpt'     => 'excerpt',
                'revisionNum' => 'ordering',
            ),
            'aliases' => array(
                'title' => 'name',
            )
        ));
        
        parent::_initialize($config);
        
        AnHelperArray::unsetValues($config->behaviors, array('commentable', 'subscribable'));
    }
}
