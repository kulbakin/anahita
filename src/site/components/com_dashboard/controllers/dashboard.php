<?php
/**
 * Dashboard Controller
 * 
 * @category   Anahita
 * @package    Com_Dashboard
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComDashboardControllerDashboard extends ComBaseControllerResource
{
    /**
     * Check if Get is allowed
     * 
     * @return boolean
     */
    public function canGet()
    {
        return ! get_viewer()->guest();
    }
}
