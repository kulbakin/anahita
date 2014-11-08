<?php
/**
 * Story Dispatcher. The story dispatcher prevent having the story name
 * as part of the document title
 * 
 * @category   Anahita
 * @package    Com_Base
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComStoriesDispatcher extends ComBaseDispatcherDefault
{
    /**
     * Sets the page title/description
     * 
     * @return void
     */
    protected function _setPageTitle()
    {
        $is_unique = $this->getController()->getState()->isUnique();
        if ( ! $is_unique) {
            parent::_setPageTitle();
        }
    }
}
