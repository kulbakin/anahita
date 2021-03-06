<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * @package     Joomla
 * @subpackage  Templates
 * @copyright   Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */
class TemplatesHelper
{
    public static function isTemplateDefault($template, $clientId)
    {
        $db =& JFactory::getDBO();
        
        // Get the current default template
        $query = ' SELECT template '
                .' FROM #__templates_menu '
                .' WHERE client_id = ' . (int) $clientId
                .' AND menuid = 0 ';
        $db->setQuery($query);
        $defaultemplate = $db->loadResult();
        
        return $defaultemplate == $template ? 1 : 0;
    }
    
    public static function isTemplateAssigned($template)
    {
        $db =& JFactory::getDBO();
        
        // check if template is assigned
        $query = 'SELECT COUNT(*)' .
                ' FROM #__templates_menu' .
                ' WHERE client_id = 0' .
                ' AND template = '.$db->Quote($template) .
                ' AND menuid <> 0';
        $db->setQuery($query);
        return $db->loadResult() ? 1 : 0;
    }
    
    public static function parseXMLTemplateFiles($templateBaseDir)
    {
        // Read the template folder to find templates
        jimport('joomla.filesystem.folder');
        $templateDirs = JFolder::folders($templateBaseDir);
        
        $rows = array();
        
        // Check that the directory contains an xml file
        foreach ($templateDirs as $templateDir) {
            if ( ! ($data = TemplatesHelper::parseXMLTemplateFile($templateBaseDir, $templateDir))) {
                continue;
            } else {
                $rows[] = $data;
            }
        }
        
        return $rows;
    }
    
    public static function parseXMLTemplateFile($templateBaseDir, $templateDir)
    {
        // Check of the xml file exists
        if ( ! is_file($templateBaseDir.DS.$templateDir.DS.'templateDetails.xml')) {
            return false;
        }
        
        $xml = JApplicationHelper::parseXMLInstallFile($templateBaseDir.DS.$templateDir.DS.'templateDetails.xml');
        if ($xml['type'] != 'template') {
            return false;
        }
        
        $data = new StdClass();
        $data->directory = $templateDir;
        
        foreach ($xml as $key => $value) {
            $data->$key = $value;
        }
        
        $data->checked_out = 0;
        $data->mosname = JString::strtolower(str_replace(' ', '_', $data->name));
        
        return $data;
    }
    
    public static function createMenuList($template)
    {
        $db =& JFactory::getDBO();
        
        // get selected pages for $menulist
        $query = 'SELECT menuid AS value' .
                ' FROM #__templates_menu' .
                ' WHERE client_id = 0' .
                ' AND template = '.$db->Quote($template);
        $db->setQuery($query);
        $lookup = $db->loadObjectList();
        if (empty( $lookup )) {
            $lookup = array( JHTML::_('select.option',  '-1' ) );
        }
        
        // build the html select list
        $options    = JHTML::_('menu.linkoptions');
        $result     = JHTML::_('select.genericlist',   $options, 'selections[]', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $lookup, 'selections' );
        return $result;
    }
}
