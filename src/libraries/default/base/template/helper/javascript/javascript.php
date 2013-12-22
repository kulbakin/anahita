<?php
/**
 * Javascript Helper
 * 
 * NOTE Expermimental and subject to change
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Template_Helper
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class LibBaseTemplateHelperJavascript extends KTemplateHelperAbstract
{
    /**
     * Compress a javascript file and put the output in the 
     *
     * @param array $config Configuration.
     *  $file   The file to compress
     *  $output The output file
     * @return void
     */
    public function combine($config = array())
    {
        $this->getService('com:base.template.helper.javascript.file', $config)
            ->write($config['output']);
    }
    
    /**
     * Loads an aray of javascript language
     * 
     * @params array $langs Array of language files
     * @return void
     */
    public function language($langs)
    {
        //force array
        settype($langs, 'array');
        
        $scripts = '';
        $tag  = JFactory::getLanguage()->getTag();
        $base = JLanguage::getLanguagePath(JPATH_ROOT, $tag);
        foreach ($langs as $lang) {
            $path = $base.'/'.$tag.'.'.$lang.'.js';
            if (is_readable($path)) {
                $content = '{'.file_get_contents($path).'}';
                $scripts .=  '<script type="text/language">'.$content.'</script>';
            }
        }
        return $scripts;
    }
}
