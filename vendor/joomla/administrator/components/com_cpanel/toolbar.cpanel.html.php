<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * @package      Joomla
 * @subpackage   Admin
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license      GNU/GPL, see LICENSE.php
 */
class TOOLBAR_cpanel
{
    public static function _DEFAULT()
    {
        JToolBarHelper::title(JText::_('Control Panel'), 'cpanel.png');
        JToolBarHelper::help('screen.cpanel');
    }
}
