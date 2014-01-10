<?php
/**
 * Html View
 * 
 * @category   Anahita
 * @package    Com_Html
 * @subpackage View
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComHtmlViewContentHtml extends ComBaseViewHtml
{
    /**
     * Constructor.
     * 
     * @param KConfig $config An optional KConfig object with configuration options.
     * @return void
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);
    }
    
    /**
     * (non-PHPdoc)
     * @see LibBaseViewAbstract::getRoute()
     */
    public function getRoute($route = "", $fqr = true)
    {
        if (is_string($route) && strpos($route,'/') && strpos($route,'layout') === false) {
            $url   = $this->getService('koowa:http.url', array('url' => $route));
            $route = $url->query;
            $route['layout'] = $url->path;
        }
        return parent::getRoute($route, $fqr);
    }
    
    /**
     * If the current layout points to a folder then set the layout to folder/default.php
     * 
     * @return void
     */
    public function display()
    {
        if (is_dir($this->getTemplate()->findPath($this->getLayout()))) {
            $this->setLayout($this->getLayout().'/default');
        }
        return parent::display();
    }
}
