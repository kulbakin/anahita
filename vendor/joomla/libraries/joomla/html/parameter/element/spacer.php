<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a spacer element
 * 
 * @package      Joomla.Framework
 * @subpackage   Parameter
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license      GNU/GPL, see LICENSE.php
 * @since        1.5
 */
class JElementSpacer extends JElement
{
    /**
     * Element name
     * 
     * @access    protected
     * @var       string
     */
    var $_name = 'Spacer';
    
    function fetchTooltip($label, $description, &$node, $control_name = '', $name = '')
    {
        return '&nbsp;';
    }
    
    function fetchElement($name, $value, &$node, $control_name)
    {
        if ($value) {
            return JText::_($value);
        } else {
            return '<hr />';
        }
    }
}
