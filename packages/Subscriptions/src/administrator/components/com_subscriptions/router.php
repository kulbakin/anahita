<?php
/**
 * Router
 * 
 * @category   Anahita
 * @package    Com_Subscriptions
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.anahitapolis.com
 */
class ComSubscriptionsRouter extends ComBaseRouterDefault
{ 
    /**
     * If the segments are empty then set the default view to packages
     * 
     * (non-PHPdoc)
     * @see ComBaseRouterAbstract::parse()
     */
    public function parse(&$segments)
    {
        if (empty($segments)) {
            $segments[] = 'packages';
        }
        return parent::parse($segments);
    }
}