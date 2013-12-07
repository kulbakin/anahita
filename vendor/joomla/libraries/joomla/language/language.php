<?php
/**
 * @category   Anahita
 * @package	   Joomla.Framework
 * @subpackage Language
 * @copyright  Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license    GNU/GPL
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Languages/translation handler class
 * 
 * This version introduces plural translation support
 * 
 * @category   Anahita
 * @package    Joomla.Framework
 * @subpackage Language
 */
class JLanguage extends JObject
{
    /**
     * Debug language, If true, highlights if string isn't found
     *
     * @var boolean
     */
    protected $_debug = false;
    
    /**
     * The default language
     *
     * The default language is used when a language file in the requested language does not exist.
     *
     * @var string
     */
    protected $_default = 'en-GB';
    
    /**
     * An array of orphaned text
     *
     * @var array
     */
    protected $_orphans = array();
    
    /**
     * Array holding the language metadata
     *
     * @var      array
     */
    protected $_metadata = null;
    
    /**
     * The language to load
     *
     * @var string
     */
    protected $_lang = null;
    
    /**
     * List of language files that have been loaded
     *
     * @var array of arrays
     */
    protected $_paths = array();
    
    /**
     * Translations
     *
     * @var array
     */
    protected $_strings = null;
    
    /**
     * An array of used text, used during debugging
     *
     * @var array
     */
    protected $_used = array();
    
    /**
     * Array of rules to transform a number to plural index
     * (initialized by constructor)
     * 
     * @var callback
     */
    public static $pluralForms = array();
    
    /**
     * Constructor activating the default information of the language
     */
    public function __construct($lang = null)
    {
        $this->_strings = array ();
        
        if ($lang == null) {
            $lang = $this->_default;
        }
        
        $this->setLanguage($lang);
        $this->load();
    }
    
    /**
     * Returns a reference to a language object
     *
     * This method must be invoked as:
     *         <pre>  $browser = &JLanguage::getInstance([$lang);</pre>
     *
     * @access   public
     * @param    string $lang  The language to use.
     * @return   JLanguage  The Language object.
     * @since    1.5
     */
    public static function &getInstance($lang)
    {
        $instance = new JLanguage($lang);
        $reference = &$instance;
        return $reference;
    }
    
    /**
     * Translate function, mimics the php gettext (alias _) function
     *
     * @param    string    $string     The string to translate
     * @param    boolean   $jsSafe     Make the result javascript safe
     * @return   string    The translation of the string
     */
    public function _($string, $jsSafe = false)
    {
        $key = strtoupper($string);
        $key = substr($key, 0, 1) == '_' ? substr($key, 1) : $key;
        
        if (isset($this->_strings[$key])) {
            $string = $this->_debug ? "-".$this->_strings[$key]."-" : $this->_strings[$key];
            
            // Store debug information
            if ($this->_debug) {
                $caller = $this->_getCallerInfo();
                
                if ( ! array_key_exists($key, $this->_used)) {
                    $this->_used[$key] = array();
                }
                
                $this->_used[$key][] = $caller;
            }
        } else {
            if (defined($string)) {
                $string = $this->_debug ? '!!'.constant($string).'!!' : constant($string);
                
                // Store debug information
                if ($this->_debug) {
                    $caller = $this->_getCallerInfo();
                    
                    if ( ! array_key_exists($key, $this->_used ) ) {
                        $this->_used[$key] = array();
                    }
                    
                    $this->_used[$key][] = $caller;
                }
            } else {
                if ($this->_debug) {
                    $caller    = $this->_getCallerInfo();
                    $caller['string'] = $string;
                    
                    if ( ! array_key_exists($key, $this->_orphans)) {
                        $this->_orphans[$key] = array();
                    }
                    
                    $this->_orphans[$key][] = $caller;
                    $string = '??'.$string.'??';
                }
            }
        }
        
        if ($jsSafe) {
            $string = addslashes($string);
        }
        
        return $string;
    }
    
    /**
     * Plural version of translation
     * 
     * @param string $string
     * @param int $n
     * @param bool $jsSafe
     * @return string
     */
    public function _n($string, $n, $jsSafe = false)
    {
        $key = strtoupper($string);
        $key = substr($key, 0, 1) == '_' ? substr($key, 1) : $key;
        
        $ln = substr($this->_lang, 0, 2);
        if (isset(self::$pluralForms[$this->_lang])) { // check for locale specific rule 
            $pcb = self::$pluralForms[$this->_lang];
        } elseif (isset(self::$pluralForms[$ln])) { // check for language rule
            $pcb = self::$pluralForms[$ln];
        } else { // no rule found, language does not have plural forms
            $pcb = null;
        }
        
        if ( ! empty($pcb)) { // plural callback found
            $pi = call_user_func($pcb, $n);
            $pkey = $key.'['.$pi.']';
            // construct translation key including plural form index but do so
            // only if plural form exists for function not to append index to
            // translation when original string is returned in fallback case
            if (isset($this->_strings[$pkey])) {
                $string = $string.'['.$pi.']'; 
            }
        }
        
        return $this->_($string, $jsSafe);
    }
    
    /**
     * Transliterate function
     *
     * This method processes a string and replaces all accented UTF-8 characters by unaccented
     * ASCII-7 "equivalents"
     *
     * @param    string    $string     The string to transliterate
     * @return   string    The transliteration of the string
     */
    public function transliterate($string)
    {
        $string = htmlentities(utf8_decode($string));
        $string = preg_replace(
            array('/&szlig;/', '/&(..)lig;/', '/&([aouAOU])uml;/', '/&(.)[^;]*;/'),
            array('ss',"$1", "$1".'e', "$1"),
            $string
        );
        
        return $string;
    }
    
    /**
     * Check if a language exists
     *
     * This is a simple, quick check for the directory that should contain language files for the given user.
     *
     * @param    string $lang Language to check
     * @param    string $basePath Optional path to check
     * @return   boolean True if the language exists
     */
    public function exists($lang, $basePath = JPATH_BASE)
    {
        static $paths = array();
        
        // Return false if no language was specified
        if ( ! $lang) {
            return false;
        }
        
        $path = $basePath.DS.'language'.DS.$lang;
        
        // Return previous check results if it exists
        if (isset($paths[$path])) {
            return $paths[$path];
        }
        
        // Check if the language exists
        jimport('joomla.filesystem.folder');
        
        $paths[$path] = JFolder::exists($path);
        
        return $paths[$path];
    }
    
    /**
     * Loads a single language file and appends the results to the existing strings
     *
     * @param    string    $extension     The extension for which a language file should be loaded
     * @param    string    $basePath      The basepath to use
     * @param    string    $lang          The language to load, default null for the current language
     * @param    boolean   $reload        Flag that will force a language to be reloaded if set to true
     * @return   boolean   True, if the file has successfully loaded.
     */
    public function load($extension = 'joomla', $basePath = JPATH_BASE, $lang = null, $reload = false)
    {
        if ( ! $lang ) {
            $lang = $this->_lang;
        }
        
        $path = JLanguage::getLanguagePath( $basePath, $lang);
        
        if ( !strlen( $extension ) ) {
            $extension = 'joomla';
        }
        $filename = ( $extension == 'joomla' ) ?  $lang : $lang . '.' . $extension ;
        $filename = $path.DS.$filename.'.ini';
        
        $result = false;
        if (isset($this->_paths[$extension][$filename]) && ! $reload) {
            // Strings for this file have already been loaded
            $result = true;
        } else {
            // Load the language file
            $result = $this->_load( $filename, $extension, false );
            
            // Check if there was a problem with loading the file
            if ($result === false) {
                // No strings, which probably means that the language file does not exist
                $path        = JLanguage::getLanguagePath( $basePath, $this->_default);
                $filename    = ( $extension == 'joomla' ) ?  $this->_default : $this->_default.'.'.$extension ;
                $filename    = $path.DS.$filename.'.ini';
                
                $result = $this->_load( $filename, $extension, false );
            }
            
        }
        
        return $result;
    }
    
    /**
     * Loads a language file
     *
     * This method will not note the successful loading of a file - use load() instead
     *
     * @param    string The name of the file
     * @param    string The name of the extension
     * @return   boolean True if new strings have been added to the language
     * @see      JLanguage::load()
     */
    protected function _load($filename, $extension = 'unknown', $overwrite = true)
    {
        $result = false;
        
        if ($content = @file_get_contents($filename)) {
            //Take off BOM if present in the ini file
            if ($content[0] == "\xEF" && $content[1] == "\xBB" && $content[2] == "\xBF") {
                $content = substr($content, 3);
            }
            
            $registry    = new JRegistry();
            $registry->loadINI($content);
            $newStrings    = $registry->toArray( );
            
            if (is_array($newStrings)) {
                $this->_strings = $overwrite ? array_merge($this->_strings, $newStrings) : array_merge($newStrings, $this->_strings);
                $result = true;
            }
        }
        
        // Record the result of loading the extension's file.
        if ( ! isset($this->_paths[$extension])) {
            $this->_paths[$extension] = array();
        }
        
        $this->_paths[$extension][$filename] = $result;
        
        return $result;
    }

    /**
     * Get a matadata language property
     *
     * @param    string $property   The name of the property
     * @param    mixed  $default    The default value
     * @return   mixed The value of the property
     */
    public function get($property, $default = null)
    {
        if (isset($this->_metadata[$property])) {
            return $this->_metadata[$property];
        }
        return $default;
    }

    /**
     * Determine who called JLanguage or JText
     *
     * @return array Caller information
     */
    private function _getCallerInfo()
    {
        // Try to determine the source if none was provided
        if ( ! function_exists('debug_backtrace')) {
            return null;
        }
        
        $backtrace   = debug_backtrace();
        $info        = array();
        
        // Search through the backtrace to our caller
        $continue = true;
        while ($continue && next($backtrace)) {
            $step    = current($backtrace);
            $class   = @$step['class'];
            
            // We're looking for something outside of language.php
            if ($class != 'JLanguage' && $class != 'JText') {
                $info['function']  = @$step['function'];
                $info['class']     = $class;
                $info['step']      = prev($backtrace);
                
                // Determine the file and name of the file
                $info['file']      = @$step['file'];
                $info['line']      = @$step['line'];
                
                $continue = false;
            }
        }
        
        return $info;
    }
    
    /**
     * Getter for Name
     *
     * @return string Official name element of the language
     */
    public function getName()
    {
        return $this->_metadata['name'];
    }
    
    /**
     * Get a list of language files that have been loaded
     *
     * @param    string $extension An option extension name
     * @return   array
     */
    public function getPaths($extension = null)
    {
        if (isset($extension)) {
            if (isset($this->_paths[$extension])) {
                return $this->_paths[$extension];
            }
            
            return null;
        } else {
            return $this->_paths;
        }
    }
    
    /**
     * Getter for PDF Font Name
     *
     * @return string name of pdf font to be used
     */
    public function getPdfFontName()
    {
        return $this->_metadata['pdffontname'];
    }
    
    /**
     * Getter for Windows locale code page
     *
     * @return string windows locale encoding
     */
    public function getWinCP()
    {
        return $this->_metadata['wincodepage'];
    }
    
    /**
     * Getter for backward compatible language name
     *
     * @return string backward compatible name
     */
    public function getBackwardLang()
    {
        return $this->_metadata['backwardlang'];
    }
    
    /**
     * Get for the language tag (as defined in RFC 3066)
     *
     * @return string The language tag
     */
    public function getTag()
    {
        return $this->_metadata['tag'];
    }
    
    /**
     * Get locale property
     *
     * @return string The locale property
     */
    public function getLocale()
    {
        $locales = explode(',', $this->_metadata['locale']);
        
        for ($i = 0; $i < count($locales); $i++) {
            $locale = $locales[$i];
            $locale = trim($locale);
            $locales[$i] = $locale;
        }
        
        return $locales;
    }
    
    /**
     * Get the RTL property
     *
     * @return boolean True is it an RTL language
     */
    public function isRTL()
    {
        return $this->_metadata['rtl'];
    }
    
    /**
     * Set the Debug property
     *
     * @return boolean Previous value
     */
    public function setDebug($debug)
    {
        $previous     = $this->_debug;
        $this->_debug = $debug;
        return $previous;
    }
    
    /**
     * Get the Debug property
     *
     * @return boolean True is in debug mode
     */
    public function getDebug()
    {
        return $this->_debug;
    }
    
    /**
     * Get the default language code
     *
     * @return string Language code
     */
    public function getDefault()
    {
        return $this->_default;
    }
    
    /**
     * Set the default language code
     *
     * @return string Previous value
     */
    public function setDefault($lang)
    {
        $previous       = $this->_default;
        $this->_default = $lang;
        return $previous;
    }
    
    /**
     * Get the list of orphaned strings if being tracked
     *
     * @return array Orphaned text
     */
    public function getOrphans()
    {
        return $this->_orphans;
    }
    
    /**
     * Get the list of used strings
     *
     * Used strings are those strings requested and found either as a string or a constant
     *
     * @return array Used strings
     */
    public function getUsed()
    {
        return $this->_used;
    }
    
    /**
     * Determines is a key exists
     *
     * @param    key      $key    The key to check
     * @return   boolean  True, if the key exists
     */
    public function hasKey($key)
    {
        return isset($this->_strings[strtoupper($key)]);
    }
    
    /**
     * Returns a associative array holding the metadata
     *
     * @param    string   The name of the language
     * @return   mixed    If $lang exists return key/value pair with the language metadata,
     *                    otherwise return NULL
     */
    public static function getMetadata($lang)
    {
        $path = JLanguage::getLanguagePath(JPATH_BASE, $lang);
        $file = $lang.'.xml';
        
        $result = null;
        if (is_file($path.DS.$file)) {
            $result = JLanguage::_parseXMLLanguageFile($path.DS.$file);
        }
        
        return $result;
    }
    
    /**
     * Returns a list of known languages for an area
     *
     * @param    string   $basePath     The basepath to use
     * @return   array    key/value pair with the language file and real name
     */
    public static function getKnownLanguages($basePath = JPATH_BASE)
    {
        $dir = JLanguage::getLanguagePath($basePath);
        $knownLanguages = JLanguage::_parseLanguageFiles($dir);
        
        return $knownLanguages;
    }
    
    /**
     * Get the path to a language
     *
     * @param    string    $basePath  The basepath to use
     * @param    string    $language  The language tag
     * @return   string    language related path or null
     */
    public static function getLanguagePath($basePath = JPATH_BASE, $language = null )
    {
        $dir = $basePath.DS.'language';
        if ( ! empty($language)) {
            $dir .= DS.$language;
        }
        return $dir;
    }
    
    /**
     * Set the language attributes to the given language
     *
     * Once called, the language still needs to be loaded using JLanguage::load()
     *
     * @param    string    $lang    Language code
     * @return   string    Previous value
     */
    public function setLanguage($lang)
    {
        $previous           = $this->_lang;
        $this->_lang        = $lang;
        $this->_metadata    = self::getMetadata($this->_lang);
        
        //set locale based on the language tag
        //TODO : add function to display locale setting in configuration
        $locale = setlocale(LC_TIME, $this->getLocale());
        return $previous;
    }
    
    /**
     * Searches for language directories within a certain base dir
     *
     * @param    string   $dir     directory of files
     * @return   array    Array holding the found languages as filename => real name pairs
     */
    public static function _parseLanguageFiles($dir = null)
    {
        jimport('joomla.filesystem.folder');
        
        $languages = array ();
        
        $subdirs = JFolder::folders($dir);
        foreach ($subdirs as $path) {
            $langs = JLanguage::_parseXMLLanguageFiles($dir.DS.$path);
            $languages = array_merge($languages, $langs);
        }
        
        return $languages;
    }
    
    /**
     * Parses XML files for language information
     *
     * @param    string   $dir     Directory of files
     * @return   array    Array holding the found languages as filename => metadata array
     */
    public static function _parseXMLLanguageFiles($dir = null)
    {
        if ($dir == null) {
            return null;
        }
        
        $languages = array ();
        jimport('joomla.filesystem.folder');
        $files = JFolder::files($dir, '^([-_A-Za-z]*)\.xml$');
        foreach ($files as $file) {
            if ($content = file_get_contents($dir.DS.$file)) {
                if ($metadata = JLanguage::_parseXMLLanguageFile($dir.DS.$file)) {
                    $lang = str_replace('.xml', '', $file);
                    $languages[$lang] = $metadata;
                }
            }
        }
        return $languages;
    }
    
    /**
     * Parse XML file for language information
     *
     * @param    string   $path     Path to the xml files
     * @return   array    Array holding the found metadata as a key => value pair
     */
    public static function _parseXMLLanguageFile($path)
    {
        $xml = &JFactory::getXMLParser('Simple');
        
        // Load the file
        if ( ! $xml || ! $xml->loadFile($path)) {
            return null;
        }
        
        // Check that it's am metadata file
        if ( ! $xml->document || $xml->document->name() != 'metafile') {
            return null;
        }
        
        $metadata = array ();
        
        foreach ($xml->document->metadata[0]->children() as $child) {
            $metadata[$child->name()] = $child->data();
        }
        
        return $metadata;
    }
}

// define plural forms
// languages without plural forms are not listed
JLanguage::$pluralForms = array(
    'ach' => function ($n) {return $n>1 ? 1 : 0;},
    'af'  => function ($n) {return $n!=1 ? 1 : 0;},
    'ak'  => function ($n) {return $n>1 ? 1 : 0;},
    'am'  => function ($n) {return $n>1 ? 1 : 0;},
    'an'  => function ($n) {return $n!=1 ? 1 : 0;},
    'ar'  => function ($n) {return $n==0 ? 0 : $n==1 ? 1 : $n==2 ? 2 : $n%100>=3 && $n%100<=10 ? 3 : $n%100>=11 ? 4 : 5;},
    'arn' => function ($n) {return $n > 1 ? 1 : 0;},
    'ast' => function ($n) {return $n!=1 ? 1 : 0;},
    'az'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'be'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'bg'  => function ($n) {return $n!=1 ? 1 : 0;},
    'bn'  => function ($n) {return $n!=1 ? 1 : 0;},
    'br'  => function ($n) {return $n>1 ? 1 : 0;},
    'brx' => function ($n) {return $n!=1 ? 1 : 0;},
    'bs'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    
    'ca'  => function ($n) {return $n!=1 ? 1 : 0;},
    'cs'  => function ($n) {return $n==1 ? 0 : $n>=2 && $n<=4 ? 1 : 2;},
    'csb' => function ($n) {return $n==1 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'cy'  => function ($n) {return $n==1 ? 0 : $n==2 ? 1 : $n!=8 && n!=11 ? 2 : 3;},
    
    'da'  => function ($n) {return $n!=1 ? 1 : 0;},
    'de'  => function ($n) {return $n!=1 ? 1 : 0;},
    'doi' => function ($n) {return $n!=1 ? 1 : 0;},
    
    'el'  => function ($n) {return $n!=1 ? 1 : 0;},
    'en'  => function ($n) {return $n!=1 ? 1 : 0;},
    'eo'  => function ($n) {return $n!=1 ? 1 : 0;},
    'es'  => function ($n) {return $n!=1 ? 1 : 0;},
    'et'  => function ($n) {return $n!=1 ? 1 : 0;},
    'eu'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'ff'  => function ($n) {return $n!=1 ? 1 : 0;},
    'fi'  => function ($n) {return $n!=1 ? 1 : 0;},
    'fil' => function ($n) {return $n>1 ? 1 : 0;},
    'fo'  => function ($n) {return $n!=1 ? 1 : 0;},
    'fr'  => function ($n) {return $n>1 ? 1 : 0;},
    'fur' => function ($n) {return $n!=1 ? 1 : 0;},
    'fy'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'ga'  => function ($n) {return $n==1 ? 0 : $n==2 ? 1 : $n<7 ? 2 : $n<11 ? 3 : 4;},
    'gd'  => function ($n) {return $n==1 || $n==11 ? 0 : $n==2 || $n==12 ? 1 : $n>2 && $n<20 ? 2 : 3;},
    'gl'  => function ($n) {return $n!=1 ? 1 : 0;},
    'gu'  => function ($n) {return $n!=1 ? 1 : 0;},
    'gun' => function ($n) {return $n>1 ? 1 : 0;},
    
    'ha'  => function ($n) {return $n!=1 ? 1 : 0;},
    'he'  => function ($n) {return $n!=1 ? 1 : 0;},
    'hi'  => function ($n) {return $n!=1 ? 1 : 0;},
    'hne' => function ($n) {return $n!=1 ? 1 : 0;},
    'hy'  => function ($n) {return $n!=1 ? 1 : 0;},
    'hr'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'hu'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'ia'  => function ($n) {return $n!=1 ? 1 : 0;},
    'is'  => function ($n) {return $n%10!=1 || $n%100==11 ? 1 : 0;},
    'it'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'jv'  => function ($n) {return $n!=0 ? 1 : 0;},
    
    'kn'  => function ($n) {return $n!=1 ? 1 : 0;},
    'ku'  => function ($n) {return $n!=1 ? 1 : 0;},
    'kw'  => function ($n) {return $n==1 ? 0 : $n==2 ? 1 : $n == 3 ? 2 : 3;},
    
    'lb'  => function ($n) {return $n!=1 ? 1 : 0;},
    'ln'  => function ($n) {return $n>1 ? 1 : 0;},
    'lt'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'lv'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n != 0 ? 1 : 2;},
    
    'mai' => function ($n) {return $n!=1 ? 1 : 0;},
    'mfe' => function ($n) {return $n>1 ? 1 : 0;},
    'mg'  => function ($n) {return $n>1 ? 1 : 0;},
    'mi'  => function ($n) {return $n>1 ? 1 : 0;},
    'mk'  => function ($n) {return $n==1 || $n%10==1 ? 0 : 1;},
    'mi'  => function ($n) {return $n!=1 ? 1 : 0;},
    'mni' => function ($n) {return $n!=1 ? 1 : 0;},
    'mnk' => function ($n) {return $n==0 ? 0 : $n==1 ? 1 : 2;},
    'mr'  => function ($n) {return $n!=1 ? 1 : 0;},
    'mt'  => function ($n) {return $n==1 ? 0 : $n==0 || ($n%100>1 && $n%100<11) ? 1 : $n%100>10 && $n%100<20 ? 2 : 3;},
    
    'nah' => function ($n) {return $n!=1 ? 1 : 0;},
    'nap' => function ($n) {return $n!=1 ? 1 : 0;},
    'nb'  => function ($n) {return $n!=1 ? 1 : 0;},
    'ne'  => function ($n) {return $n!=1 ? 1 : 0;},
    'ni'  => function ($n) {return $n!=1 ? 1 : 0;},
    'nn'  => function ($n) {return $n!=1 ? 1 : 0;},
    'no'  => function ($n) {return $n!=1 ? 1 : 0;},
    'nso' => function ($n) {return $n!=1 ? 1 : 0;},
    
    'oc'  => function ($n) {return $n>1 ? 1 : 0;},
    'or'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'ps'  => function ($n) {return $n!=1 ? 1 : 0;},
    'pa'  => function ($n) {return $n!=1 ? 1 : 0;},
    'pap' => function ($n) {return $n!=1 ? 1 : 0;},
    'pl'  => function ($n) {return $n==1 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'pms' => function ($n) {return $n!=1 ? 1 : 0;},
    'pt'  => function ($n) {return $n!=1 ? 1 : 0;},
    'pt-BR' => function ($n) {return $n>1 ? 1 : 0;},
    
    'rm'  => function ($n) {return $n!=1 ? 1 : 0;},
    'ro'  => function ($n) {return $n==1 ? 0 : $n==0 || ($n%100>0 && $n%100<20) ? 1 : 2;},
    'ru'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'rw'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'sat' => function ($n) {return $n!=1 ? 1 : 0;},
    'sco' => function ($n) {return $n!=1 ? 1 : 0;},
    'sd'  => function ($n) {return $n!=1 ? 1 : 0;},
    'se'  => function ($n) {return $n!=1 ? 1 : 0;},
    'si'  => function ($n) {return $n!=1 ? 1 : 0;},
    'sk'  => function ($n) {return $n==1 ? 0 : $n>=2 && $n<=4 ? 1 : 2;},
    'sl'  => function ($n) {return $n%100==1 ? 1 : $n%100==2 ? 2 : $n%100==3 || $n%100==4 ? 3 : 0;},
    'so'  => function ($n) {return $n!=1 ? 1 : 0;},
    'son' => function ($n) {return $n!=1 ? 1 : 0;},
    'sq'  => function ($n) {return $n!=1 ? 1 : 0;},
    'sr'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'sw'  => function ($n) {return $n!=1 ? 1 : 0;},
    'sv'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'ta'  => function ($n) {return $n!=1 ? 1 : 0;},
    'te'  => function ($n) {return $n!=1 ? 1 : 0;},
    'tg'  => function ($n) {return $n>1 ? 1 : 0;},
    'ti'  => function ($n) {return $n>1 ? 1 : 0;},
    'tk'  => function ($n) {return $n!=1 ? 1 : 0;},
    'tr'  => function ($n) {return $n>1 ? 1 : 0;},
    
    'uk'  => function ($n) {return $n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2;},
    'ur'  => function ($n) {return $n!=1 ? 1 : 0;},
    'uz'  => function ($n) {return $n>1 ? 1 : 0;},
    
    'wa'  => function ($n) {return $n>1 ? 1 : 0;},
    
    'yo'  => function ($n) {return $n!=1 ? 1 : 0;},
    
    'zh'  => function ($n) {return $n>1 ? 1 : 0;},
);
