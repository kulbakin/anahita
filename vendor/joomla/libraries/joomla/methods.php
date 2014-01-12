<?php
/**
 * @category    Anahita
 * @package     Joomla.Framework
 * @copyright   Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license     GNU/GPL
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Route handling class
 * 
 * @category    Anahita
 * @package     Joomla.Framework
 */
class JRoute
{
    /**
     * Translates an internal Joomla URL to a humanly readible URL.
     *
     * @param  string   $url   Absolute or Relative URI to Joomla resource
     * @param  boolean  $fqr   Whether to return full url
     * @return The translated humanly readible URL
     */
    public static function _($url, $fqr = false)
    {
        return KService::get('application')
            ->getRouter()
            ->build($url, $fqr);
    }
}

/**
 * Text  handling class
 * 
 * @category    Anahita
 * @package     Joomla.Framework
 * @subpackage  Language
 */
class JText
{
    /**
     * Translates a string into the current language
     *
     * @param   string  $string The string to translate
     * @param   boolean $jsSafe Make the result javascript safe
     * @return  string
     */
    public static function _($string, $jsSafe = false)
    {
        return JFactory::getLanguage()->_($string, $jsSafe);
    }
    
    /**
     * Plural version of translate function
     *
     * @param   string  $string The string to translate
     * @param   int     $n      Number
     * @param   boolean $jsSafe Make the result javascript safe
     * @return  string
     */
    public static function _n($string, $n, $jsSafe = false)
    {
        return JFactory::getLanguage()->_n($string, $n, $jsSafe);
    }
    
    /**
     * Passes a string through sprintf
     * 
     * @param   string $format The format string
     * @param   int    $n      Number
     * @param   mixed  $args Mixed number of arguments for the sprintf function
     * $param   mixed  $...
     * @return  string
     */
    public static function nsprintf($format, $n)
    {
        $args = func_get_args();
        if (count($args) > 1) {
            $args[0] = JFactory::getLanguage()->_n($args[0], $args[1]);
        }
        return  call_user_func_array('sprintf', $args);
    }
    
    /**
     * Passes a string through sprintf
     * 
     * @param   string $format The format string
     * @param   mixed  $args Mixed number of arguments for the sprintf function
     * $param   mixed  $...
     * @return  string
     */
    public static function sprintf($format)
    {
        $args = func_get_args();
        if (count($args) > 0) {
            $args[0] = JFactory::getLanguage()->_($args[0]);
        }
        return call_user_func_array('sprintf', $args);
    }
    
    /**
     * Passes a string thrugh printf
     * 
     * @param   string $format The format string
     * @param   mixed  $args Mixed number of arguments for the sprintf function
     * $param   mixed  $...
     * @return  int
     */
    public static function printf($string)
    {
        $args = func_get_args();
        if (count($args) > 0) {
            $args[0] = JFactory::getLanguage()->_($args[0]);
        }
        return call_user_func_array('printf', $args);
    }
}
