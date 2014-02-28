<?php
/**
 * Notification Router
 * 
 * @category   Anahita
 * @package    Com_Notifications
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComNotificationsRouter extends ComBaseRouterDefault
{
    /**
     * (non-PHPdoc)
     * @see ComBaseRouterAbstract::parse()
     */
    public function parse(&$segments)
    {
        $query = array();
        $path  = implode('/', $segments);
        if ($path == 'new') {
            array_pop($segments);
            $query = array_merge(parent::parse($segments), array('new' => true));
        } else {
            return parent::parse($segments);
        }
        return $query;
    }
}
