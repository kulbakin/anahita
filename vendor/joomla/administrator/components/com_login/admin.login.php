<?php
/**
 * @package    Joomla
 * @subpackage Joomla.Extensions
 * @copyright  Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license    GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

switch (JRequest::getCmd('task')) {
    case 'login':
        LoginController::login();
        break;
    case 'logout':
        LoginController::logout();
        break;
    default:
        LoginController::display();
        break;
}

/**
 * Static class to hold controller functions for the Login component
 *
 * @package    Joomla
 * @subpackage Login
 * @since      1.5
 */
class LoginController
{
    public static function display()
    {
        jimport('joomla.application.module.helper');
        $module = & JModuleHelper::getModule('mod_login');
        $module = JModuleHelper::renderModule($module, array('style' => 'rounded', 'id' => 'section-box'));
        echo $module;
    }
    
    public static function login()
    {
        global $mainframe;
        
        // Check for request forgeries
        JRequest::checkToken('request') or jexit( 'Invalid Token' );
        
        $credentials = array();
        
        $credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
        $credentials['password'] = JRequest::getVar('passwd', '', 'post', 'string', JREQUEST_ALLOWRAW);
        
        $result = $mainframe->login($credentials);
        
        if ( ! JError::isError($result)) {
            $mainframe->redirect('index.php');
        }
        
        LoginController::display();
    }
    
    public static function logout()
    {
        global $mainframe;
        
        $result = $mainframe->logout();
        
        if ( ! JError::isError($result)) {
            $mainframe->redirect('index.php?option=com_login');
        }
        
        LoginController::display();
    }
}
