<?php
/**
 * File View
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage View
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComBaseViewFile extends LibBaseViewFile
{
    /**
     * Return the views output
     * 
     * @return string The output of the view
     */
    public function display()
    {
        if ($this->entity && $this->entity->isFileable()) {
            $this->output   = $this->entity->getFileContent();
            $this->mimetype = $this->entity->mimetype;
            $this->filename = $this->entity->filename;
        }
        return parent::display();
    }
}
