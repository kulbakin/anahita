<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * @package     Joomla.Framework
 * @subpackage        Language
 * @subpackage   Language
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license      GNU/GPL, see LICENSE.php
 * @since 1.5
 */
class JLanguageHelper
{
    /**
     * Builds a list of the system languages which can be used in a select option
     *
     * @param    string    Client key for the area
     * @param    string    Base path to use
     * @param    array     An array of arrays ( text, value, selected )
     * @since    1.5
     */
    public static function createLanguageList($actualLanguage, $basePath = JPATH_BASE, $caching = false)
    {
        $list = array ();
        
        // cache activation
        $langs = JLanguage::getKnownLanguages($basePath);
        
        foreach ($langs as $lang => $metadata) {
            $option = array ();
            
            $option['text'] = $metadata['name'];
            $option['value'] = $lang;
            if ($lang == $actualLanguage) {
                $option['selected'] = 'selected="selected"';
            }
            $list[] = $option;
        }
        
        return $list;
    }
    
    /**
      * Tries to detect the language
      *
      * @return   string locale
      * @since    1.5
      */
    public static function detectLanguage()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $systemLangs  = JLanguage::getKnownLanguages();
            $browserLangs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            
            foreach ($browserLangs as $browserLang) {
                // slice out the part before ; on first step, the part before - on second, place into array
                $browserLang = substr($browserLang, 0, strcspn($browserLang, ';'));
                $primary_browserLang = substr($browserLang, 0, 2);
                
                foreach($systemLangs as $systemLang => $metadata) {
                    if (strtolower($browserLang) == strtolower(substr($metadata['tag'], 0, strlen($browserLang)))) {
                        return $systemLang;
                    } elseif ($primary_browserLang == substr($metadata['tag'], 0, 2)) {
                        $primaryDetectedLang = $systemLang;
                    }
                }
                
                if (isset($primaryDetectedLang)) {
                    return $primaryDetectedLang;
                }
            }
        }
        
        return 'en-GB';
    }
}
