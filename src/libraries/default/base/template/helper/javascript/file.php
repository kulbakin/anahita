<?php
/**
 * Helper to manipulate javascript sources
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Template_Helper
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class LibBaseTemplateHelperJavascriptFile extends KTemplateHelperAbstract 
{
    /**
     * Cache dir
     * 
     * @var string
     */
    protected $_cache_dir;
    
    /**
     * Cached data
     * 
     * @var array
     */
    protected $_cache_data;
    
    /**
     * File
     * 
     * @var string
     */
    protected $_file;
    
    /**
     * Constructor.
     * 
     * @param KConfig $config An optional KConfig object with configuration options.
     * @return void
     */
    public function __construct(KConfig $config)
    {
        $this->_file = $config->file;
        
        parent::__construct($config);
        
        $this->_cache_file = $config->cache_file;
        
        if (is_readable($this->_cache_file)) {
            $this->_cache_data = unserialize(file_get_contents($this->_cache_file));
        }
        
        if ( ! is_array($this->_cache_data)) {
            $this->_cache_data = array();
        }
        
        if ( ! isset($this->_cache_data['timestamp'])) {
            $this->_cache_data = array('timetamp' => time());
        }
    }
    
    /**
     * Initializes the default configuration for the object
     * 
     * Called from {@link __construct()} as a first step of object instantiation.
     * 
     * @param KConfig $config An optional KConfig object with configuration options.
     * @return void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'cache_file' => JPATH_CACHE.'/'.basename($this->_file).'.'.md5($this->_file)
        ));
        
        parent::_initialize($config);
    }
    
    /**
     * Return the content of the file and all of the files included in it
     * 
     * @return string
     */
    public function getData()
    {
        return $this->_parseFile($this->_file);
    }
    
    /**
     * Write the output of the file into and output
     * 
     * @param string  $output Compress file
     * @param boolean $force  Determine whether to foce the compression regardless of the cache value
     * @return string
     */
    public function write($output)
    {
        // lets parse the file
        if ( ! file_exists($output) || $this->_hasBeenModified($this->_file)) {
            // get the data
            file_put_contents($output, $this->getData());
            // update the timestamp
            $this->_cache_data['timestamp'] = time();
            file_put_contents($this->_cache_file, serialize($this->_cache_data));
            
            // store minified version
            $minifier = new \MatthiasMullie\Minify\JS($this->getData());
            file_put_contents(preg_replace('%\.js$%', '.min.js', $output), $minifier->minify());
        }
    }
    
    /**
     * Parses a file and return its content. The method traverse through
     * all the imported javascript file within the file and append their 
     * content to the content of the $file
     * 
     * @param string $file The file to parse
     * @return string
     */
    protected function _parseFile($file)
    {
        //if modified parse it again
        if ($this->_hasBeenModified($file)) {
            $imports = array();
            $content = file_get_contents($file);
            //lets compress the file
            $matches = array();
            $dir     = dirname($file);
            if (preg_match_all('/\/\/@depends (.*)/', $content, $matches)) {
                foreach ($matches[1] as $i => $match) {
                    $imported_file = $dir.'/'.trim($match);
                    $imports[] = $imported_file;
                    if (file_exists($imported_file)) {
                        $data    = $this->_parseFile($imported_file);
                        $content = str_replace($matches[0][$i], $data, $content);
                    }
                }
            }
            $content = "//".str_replace(JPATH_ROOT, '', $file)."\n".$content;
            $this->_cache_data[$file] = array('data' => $content, 'imports' => $imports);
        } else {
            $content = $this->_cache_data[$file]['data'];
        }
        return $content;
    }
    
    /**
     * Check if the file or any of the imported files within it has been modified since 
     * the last time it was cached
     * 
     * @param string $file The file to check
     * @return boolean
     */
    protected function _hasBeenModified($file)
    {
        if ( ! isset($this->_cache_data[$file])) {
            return true;
        }
        
        if (filemtime($file) > $this->_cache_data['timestamp']) {
            return true;
        }
        
        $imports = $this->_cache_data[$file]['imports'];
        
        foreach ($imports as $import) {
            if ($this->_hasBeenModified($import)) {
                return true;
            }
        }
        
        return false;
    }
}
