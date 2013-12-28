<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * File session handler for PHP
 * 
 * @package      Joomla.Framework
 * @subpackage   Session
 * @subpackage   Session
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @since        1.5
 * @see http://www.php.net/manual/en/function.session-set-save-handler.php
 */
class JSessionStorageNone extends JSessionStorage
{
    /**
     * Register the functions of this class with PHP's session handler
     * 
     * @access public
     * @param array $options optional parameters
     */
    function register($options = array())
    {
        //let php handle the session storage
    }
}
