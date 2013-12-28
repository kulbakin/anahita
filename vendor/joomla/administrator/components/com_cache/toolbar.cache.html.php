<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     Joomla
 * @subpackage  Cache
 * @license     GNU/GPL, see LICENSE.php
 * @copyright   Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 */
class TOOLBAR_cache
{
    /**
     * Draws the menu for a New category
     */
    public static function _DEFAULT()
    {
        JToolBarHelper::title( JText::_( 'Cache Manager - Clean Cache Admin' ), 'checkin.png' );
        JToolBarHelper::custom( 'delete', 'delete.png', 'delete_f2.png', 'Delete', true );
        JToolBarHelper::help( 'screen.cache' );
    }
    
    public static function _PURGEADMIN()
    {
        JToolBarHelper::title( JText::_( 'Cache Manager - Purge Cache Admin' ), 'checkin.png' );
        JToolBarHelper::custom( 'purge', 'delete.png', 'delete_f2.png', 'Purge expired', false );
        JToolBarHelper::help( 'screen.cache' );
    }
}
