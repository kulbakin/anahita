<?php
/**
 * Converts endlines to html p tags
 * 
 * @category   Anahita
 * @package    Plg_Contentfilter
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class PlgContentfilterPtag extends PlgContentfilterAbstract
{
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
            'priority' => KCommand::PRIORITY_LOWEST,
        ));
        
        parent::_initialize($config);
    }
    
    /**
     * Filter a value
     * 
     * @param string The text to filter
     * @return string
     */
    public function filter($text)
    {
        $this->_stripTags($text);
        
        $paragraphs = array();
        foreach (preg_split("%\s*[\n\r]\s*%", trim($text)) as $p) {
            $paragraphs[] = '<p>'.$p.'</p>';
        }
        
        $text = implode($paragraphs, "\n");
        $this->_replaceTags($text);
        
        return $text;
    }
}
