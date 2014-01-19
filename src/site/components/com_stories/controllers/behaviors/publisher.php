<?php
/**
 * Publisher Behavior. Publishes stories after an action
 * 
 * @category   Anahita
 * @package    Com_Stories
 * @subpackage Controller_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2011 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComStoriesControllerBehaviorPublisher extends KControllerBehaviorAbstract
{
    /**
     * Creates a story
     * 
     * @param array|KCommandContext $config Config. Can be a story data or KCommandContext if the method
     *  is used as a callback
     * @param bool[optional] $is_exclusive if the story is exclusive meaning only 1 story of specified name
     *  can exist for each owner-target combination
     * @return ComStoriesDomainEntityStory
     */
    public function createStory($config = array(), $is_exclusive = false)
    {
        $config = new KConfig($config);
        
        $config->append(array(
            'subject'   => get_viewer(),
            'owner'     => get_viewer(),
            'component' => 'com_'.$this->_mixer->getIdentifier()->package,
        ));
        
        $repo = $this->getService('repos://site/stories');
        if ($is_exclusive) {
            $repo->getQuery(true)
                ->where('name', '=', $config->name)
                ->where('owner', '=', $config->owner)
                ->where('target', '=', $config->target)
                ->destroy();
        }
        
        $story = $repo->create($config->toArray());
        $story->save();
        
        return $story;
    }
}
