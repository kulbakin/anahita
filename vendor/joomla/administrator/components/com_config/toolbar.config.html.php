<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package		Joomla
 * @subpackage	Config
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license      GNU/GPL, see LICENSE.php
 */
class TOOLBAR_config
{
    public static function _DEFAULT()
    {
        JToolBarHelper::title(JText::_('Global Configuration'), 'config.png');
        JToolBarHelper::save();
        JToolBarHelper::apply();
        JToolBarHelper::cancel('cancel', 'Close');
        JToolBarHelper::help('screen.config');
    }
}
