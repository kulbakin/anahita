<?php
/**
 * Invites Router
 * 
 * @category   Anahita
 * @package    Com_Invites
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComInvitesRouter extends ComBaseRouterAbstract
{
    /**
     * (non-PHPdoc)
     * @see ComBaseRouterAbstract::parse()
     */
    public function parse(&$segments)
    {
        $path = implode('/', $segments);
        
        if (empty($segments)) {
            $segments[] = 'email';
        }
        
        if (preg_match('#(connections|token)(/\w+)?#', $path)) {
           return array(
               'view'   => array_shift($segments), 
               'service'=> pick('facebook',array_pop($segments))
           );
        }
        
        return parent::parse($segments);
    }
    
    /**
     * Builds a query
     * 
     * @param array $query
     * @return array
     */
    public function build(&$query)
    {
        if (isset($query['view']) && $query['view'] == 'connections' &&  isset($query['service'])) {
            $segments = array('connections', 'service' => $query['service']);
            unset($query['service']);
            unset($query['view']);
            return $segments; 
        }
        
        return parent::build($query);
    }
}
