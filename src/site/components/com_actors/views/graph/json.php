<?php
/**
 * Graph json view
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage View
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComActorsViewGraphJson extends LibBaseViewJson
{ 
    /**
     * The name is used as the data key we want that name to be actors
     * 
     * @return string
     */
    public function getName()
    {
        return 'actors';
    }
    
    /**
     * Graph is singular name but we always want it to return list
     * 
     * @return array
     */
    protected function _getItem()
    {
        return $this->_getList();
    }
}
