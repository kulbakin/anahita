<?php
/**
 * Abstract Medium Controller
 * 
 * @category   Anahita
 * @package    Com_Medium
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
abstract class ComMediumControllerAbstract extends ComBaseControllerService
{
    /**
     * Constructor.
     * 
     * @param KConfig $config An optional KConfig object with configuration options.
     * @return void
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);
        
        $this->registerCallback(array('after.add'), array($this, 'createStoryCallback'));
        
        //add medium related states
        $this->getState()->insert('filter')->insert('grid')->insert('order');
        
        $this->registerCallback(array('after.delete', 'after.add', 'after.edit'), array($this, 'redirect'));
    }
    
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
            'state' => array(
                'viewer' => get_viewer(),
            ),
            'request' => array(
                'filter' => null,
                'order'  => null
            ),
            'behaviors' => to_hash(array(
                'com://site/search.controller.behavior.searchable',
                'com://site/stories.controller.behavior.publisher',
                'com://site/notifications.controller.behavior.notifier',
                'composable',
                'commentable',
                'votable',
                'privatable',
                'subscribable',
            )),
        ));
        
        //anything within the medium app
        //is within the context of an owner
        //we need to set the default owner to the viewer
        $config->append(array(
            'behaviors' => array(
                'ownable' => array('default' => get_viewer()),
            ),
        ));
        
        parent::_initialize($config);
    }
    
    /**
     * Browse Action
     * 
     * @param KCommandContext $context Context Parameter
     * @return AnDomainQuery
     */
    protected function _actionBrowse(KCommandContext $context)
    {
        $entities = parent::_actionBrowse($context);
        
        if ($this->filter == 'leaders') {
           $leaderIds = array();
           $leaderIds[] = $this->viewer->id;
           $leaderIds = array_merge($leaderIds, $this->viewer->getLeaderIds()->toArray());
           $entities->where('owner.id', 'IN', $leaderIds);
        } elseif (
            $this->getRepository()->hasBehavior('ownable')
            && $this->actor 
            && $this->actor->id > 0
        ) {
            $entities->where('owner', '=', $this->actor);
        }
        
        return $entities;
    }
    
    /**
     * Set the necessary redirect
     * 
     * @param KCommandContext $context
     * @return void
     */
    public function redirect(KCommandContext $context)
    {
        if ('delete' == $context->action) {
            $url['oid']    = $this->getItem()->owner->id;
            $url['view']   = KInflector::pluralize($this->getIdentifier()->name);
            $url['option'] = $this->getIdentifier()->package;
            $this->getResponse()->setRedirect(JRoute::_($url));
        } elseif ('add' == $context->action or 'edit' == $context->action) {
            $url['id']     = $this->getItem()->id;
            $url['view']   = KInflector::pluralize($this->getIdentifier()->name);
            $url['option'] = $this->getIdentifier()->package;
            $this->getResponse()->setRedirect(JRoute::_($url));
        }
    }
    
    /**
     * Set the default Actor View
     * 
     * @param KCommandContext $context Context parameter
     * @return ComActorsControllerDefault
     */
    public function setView($view)
    {
        parent::setView($view);
        
        if ( ! $this->_view instanceof ComBaseViewAbstract) {
            $name  = KInflector::isPlural($this->view) ? 'media' : 'medium';
            $defaults[] = 'ComMediumView'.ucfirst($view).ucfirst($this->_view->name);
            $defaults[] = 'ComMediumView'.ucfirst($name).ucfirst($this->_view->name);
            $defaults[] = 'ComBaseView'.ucfirst($this->_view->name);
            
            register_default(array('identifier'=>$this->_view, 'default'=>$defaults)); 
        }
        
        return $this;
    }
    
    /**
     * Can be used as a cabllack to automatically create a story
     * 
     * @param KCommandContext $context
     * @return ComStoriesDomainEntityStory
     */
    public function createStoryCallback(KCommandContext $context)
    {
        if ($context->result !== false) {
            $data = $context->data;
            $name = $this->getIdentifier()->name.'_'.$context->action;
            $context->append(array(
                'story' => array(
                    'component' => 'com_'.$this->getIdentifier()->package,
                    'name'      => $name,
                    'owner'     => $this->actor,
                    'object'    => $this->getItem(),
                    'target'    => $this->actor,
                    'comment'   => $this->isCommentable() ? $data->comment : null
                ),
            ));
            $story = $this->createStory(KConfig::unbox($context->story));
            $data->story = $story;
            return $story;
        }
        return $context->result;
    }
}
