<?php
/**
 * Creates a story after creating a new comment
 * 
 * @category   Anahita
 * @package    Com_Medium
 * @subpackage Controller_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComMediumControllerBehaviorCommentable extends ComBaseControllerBehaviorCommentable
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
        
        if ($this->_mixer->isPublisher()) {
            $this->registerCallback('after.addcomment', array($this, 'createCommentStory'));
        }
    }
    
    /**
     * Create a story after a comment
     * 
     * @param KCommandContext $context
     * @return void
     */
    public function createCommentStory(KCommandContext $context)
    {
        //called by the comment controller as as callback
        $entity = $context->comment;
        $parent = $context->comment->parent;
        $owner  = $entity->author;
        
        if ($parent->isOwnable()) {
            $owner  = $parent->owner;
        }
        
        $data = array(
            'name'      => $parent->getIdentifier()->name.'_comment',
            'component' => $parent->component,
            'comment'   => $entity,
            'object'    => $parent,
            'owner'     => $owner,
            'target'    => $parent->isOwnable() ? $parent->owner : null
        );
        
        $story = $this->_mixer->createStory($data);
        if ($story) {
            $story->save();
        }
        
        if ($this->isNotifier()) {
            //story owner
            $data['subscribers'] = array($owner);
            
            //all the not subscribers
            if ($parent->isSubscribable()) {
                $data['subscribers'][] = $parent->subscriberIds->toArray();
            }
            
            $notification = $this->_mixer->createNotification($data);
            
            if ($notification) {
                $notification->setType('post');
                $notification->save();
            }
        }
    }
}
