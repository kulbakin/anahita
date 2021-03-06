<?php
/**
 * @package     Joomla
 * @subpackage  Modules
 * @copyright   Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */
class TOOLBAR_modules
{
    /**
     * Draws the menu for a New module
     */
    public static function _NEW($client)
    {
        JToolBarHelper::title( JText::_( 'Module' ) . ': <small><small>[ '. JText::_( 'New' ) .' ]</small></small>', 'module.png' );
        JToolBarHelper::customX( 'edit', 'forward.png', 'forward_f2.png', 'Next', true );
        JToolBarHelper::cancel();
        if ($client->name == 'site') {
            JToolBarHelper::help( 'screen.modulessite.edit' );
        } else {
            JToolBarHelper::help( 'screen.modulesadministrator.edit');
        }
    }
    
    /**
     * Draws the menu for Editing an existing module
     */
    public static function _EDIT($client)
    {
        $moduleType = JRequest::getCmd( 'module' );
        $cid        = JRequest::getVar( 'cid', array(0), '', 'array' );
        JArrayHelper::toInteger($cid, array(0));
        
        JToolBarHelper::title(JText::_('Module').': <small><small>[ '.JText::_('Edit').' ]</small></small>', 'module.png');
        
        JToolBarHelper::save();
        JToolBarHelper::apply();
        if ($cid[0]) {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel( 'cancel', 'Close' );
        } else {
            JToolBarHelper::cancel();
        }
        JToolBarHelper::help('screen.modules.edit');
    }
    
    public static function _DEFAULT($client)
    {
        JToolBarHelper::title(JText::_('Module Manager' ), 'module.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::custom('copy', 'copy.png', 'copy_f2.png', 'Copy', true);
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();
        JToolBarHelper::help('screen.modules');
    }
}
