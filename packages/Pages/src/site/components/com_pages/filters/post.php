<?php
/**
 * Post Filter
 * 
 * @category   Anahita
 * @package    Com_pages
 * @subpackage Filter
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPagesFilterPost extends ComMediumFilterPost
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
            'tag_list'   => array('img', 'a', 'blockquote', 'strong', 'em', 'ul', 'ol', 'li', 'code', 'h2', 'h3', 'h4'),
            'tag_method' => 0,
        ));
        
        parent::_initialize($config);
    }
}
