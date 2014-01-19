<?php
/**
 * Todolist Entity
 * 
 * @category   Anahita
 * @package       Com_Todos
 * @subpackage Domain_Entity
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComTodosDomainEntityTodolist extends ComMediumDomainEntityMedium 
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
            'resources'  => array('todos_todolists'),
            'attributes' => array(
                    'name'          => array('required' => true),
                    'todoCount'     => array('column' => 'todos_count', 'default' => '0', 'type' => 'integer', 'write' => 'private'),
                    'openTodoCount' => array('column' => 'open_todos_count', 'default' => '0', 'type' => 'integer', 'write' => 'private'),
            ),
            'relationships' => array(
                'todos',
            ),
            'behaviors' => array(
                'parentable' => array('parent' => 'milestone'),
            ),
            
            // XXX backward compatibility synonyms, it is advised to use primary names: commentStatus and commentCount
            'aliases' => array(
                'numOfTodos'     => 'todoCount',
                'numOfOpenTodos' => 'openTodoCount',
            )
        ));
        
        parent::_initialize($config);
        
        AnHelperArray::unsetValues($config->behaviors, 'commentable');
    }
    
    /**
     * Set the todolist
     * 
     * @param ComTodosDomainEntityMilestone $parent Milestone
     * @return void
     */
    public function setParent($parent)
    {
        $commands = array('after.insert', 'after.update', 'after.delete');
        if ($parent) {
            $this->getRepository()
                ->registerCallback($commands, array($parent, 'updateStats'));
        }
        if ($this->parent) {
            $this->getRepository()
                ->registerCallback($commands, array($this->parent, 'updateStats'));
        }
        $this->set('parent', $parent);
    }
    
    /**
     * Update the todolists stats
     * 
     * @return void
     */
    public function updateStats()
    {
        $this->set('todoCount', $this->todos->reset()->getTotal());
        $this->set('openTodoCount', $this->todos->reset()->where('open', '=', true)->getTotal());
    }
}
