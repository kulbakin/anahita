<?php
/**
 * @category   Anahita
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */

// no direct access
defined( 'JPATH_BASE' ) or die( 'Restricted access' );

require_once ( JPATH_BASE.'/includes/framework.php' );

KService::get('com://admin/application.dispatcher')->run();

exit(0);
