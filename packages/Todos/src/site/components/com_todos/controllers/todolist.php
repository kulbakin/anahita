<?php
/**
 * Todo Controller
 * 
 * @category   Anahita
 * @package    Com_Todos
 * @subpackage Controller
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2013 rmdStudio Inc.
 */
class ComTodosControllerTodolist extends ComMediumControllerDefault
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
            'request' => array('pid' => null),
            'behaviors' => array(
                'parentable'
            )
        ));
        
        parent::_initialize($config);
    }
}
