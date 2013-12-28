<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     Joomla
 * @subpackage  Languages
 * @copyright   Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */
class TOOLBAR_languages
{
    public static function _DEFAULT()
    {
        JToolBarHelper::title(JText::_('Language Manager' ), 'langmanager.png');
        JToolBarHelper::makeDefault('publish');
        JToolBarHelper::help('screen.languages');
    }
}