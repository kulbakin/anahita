<?php
/**
 * Milestone Entity
 * 
 * @category   Anahita
 * @package       Com_Todos
 * @subpackage Domain_Entity
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComTodosDomainEntityMilestone extends ComMediumDomainEntityMedium
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
            'resources'  => array('todos_milestones'),
            'attributes' => array(
                'name'          => array('required' => true),
                'todolistCount' => array('column' => 'todolists_count', 'write' => 'private'),
                'endDate'       => array('type' => 'date', 'default' => 'date')
            ),
            'relationships' => array(
                'todolists',
            ),
            
            // XXX backward compatibility synonyms, it is advised to use primary names: commentStatus and commentCount
            'aliases' => array(
                'numOfTodolists' => 'todolistCount',
            )
        ));
        
        parent::_initialize($config);
    }
    
    /**
     * Set End Date
     * 
     * @param  string $date
     * @return void
     */
    public function setEndDate($date)
    {
        $date = AnDomainAttribute::getInstance('date')->setDate($date);
        $date = $date->toDate()->modify('+23 hours, 59 minutes, 59 seconds');
        
        //the date is set in a the viewer's timezone
        $date->addHours(get_viewer()->timezone * -1);
        
        $this->set('endDate', $date);
    }
    
    /**
     * Update the todolists stats
     * 
     * @return void
     */
    public function updateStats()
    {
        $this->set('todolistCount', $this->todolists->reset()->getTotal());
    }
}
