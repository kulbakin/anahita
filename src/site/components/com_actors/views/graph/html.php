<?php
/**
 * Default Social Graph
 * 
 * @category   Anahita
 * @package    Com_Actors
 * @subpackage View
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComActorsViewGraphHtml extends ComActorsViewActorsHtml
{
    /**
     * Initializes the options for the object
     * 
     * Called from {@link __construct()} as a first step of object instantiation.
     * 
     * @param object An optional KConfig object with configuration options.
     * @return void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'list_item_view' => KInflector::singularize($this->getIdentifier()->package),
        ));
        
        parent::_initialize($config);
        
        $config->template_paths = AnHelperArray::insert($config->template_paths, dirname(__FILE__).'/html', 1);
    }
}
