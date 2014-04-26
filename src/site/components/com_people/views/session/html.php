<?php
/**
 * @category   Anahita
 * @package    Com_People
 * @subpackage View
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPeopleViewSessionHtml extends ComBaseViewHtml
{
    /**
     * (non-PHPdoc)
     * @see LibBaseViewHtml::display()
     */
    public function display()
    {
        if ($this->_state->getItem()) {
            $url = $this->getRoute($this->_state->getItem()->getURL());
            $this->getService('application')->redirect($url);
        }
        
        if ($this->_state->return) {
            //$this->return = $this->_state->return;
        }
        
        return parent::display();
    }
}
