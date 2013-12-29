<?php
/**
 * Router
 * 
 * @category   Anahita
 * @package    Com_Subscriptions
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComSubscriptionsRouter extends ComBaseRouterDefault
{    
    /**
     * Parse the segments of a URL.
     * 
     * @param   array   The segments of the URL to parse.
     * @return  array   The URL attributes to be used by the application.
     */
    public function parse(&$segments)
    {
        $query = array();
        
        if ( ! count($segments)) {
            $query['view'] = 'packages';
        } else {
            $query = parent::parse($segments);
        }
        
        return $query;
    }
}
