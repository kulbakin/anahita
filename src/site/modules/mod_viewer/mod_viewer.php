<?php defined('KOOWA') or die('Restricted access');

/**
 * @category   Anahita
 * @package    Mod_Actor
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */

print KService::get('mod://site/viewer.module', array(
    'request' => $params->toArray()
))->display();