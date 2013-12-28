<?php
defined('JPATH_BASE') or die();
/**
 * Utility class for form elements
 * 
 * @package     Joomla.Framework
 * @subpackage  HTML
 * @copyright   Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 * @version     1.5
 */
class JHTMLForm
{
    /**
     * Displays a hidden token field to reduce the risk of CSRF exploits
     * 
     * Use in conjuction with JRequest::checkToken
     * 
     * @return void
     * @since  1.5
     */
    public static function token()
    {
        return '<input type="hidden" name="'.JUtility::getToken().'" value="1" />';
    }
}
