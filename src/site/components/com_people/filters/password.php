<?php
/**
 * Password filter.
 * 
 * @category   Anahita
 * @package    Com_People
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPeopleFilterPassword extends KFilterRaw
{
    /**
     * Password min length 
     */
    public static $MIN_LENGTH = 6;
    
    /**
     * Sanitize a value
     * 
     * @param   mixed   Value to be sanitized
     * @return  string
     */
    protected function _validate($value)
    {
        $ret = parent::_validate($value);
        if ($ret)  {
            if (strlen($value) < self::$MIN_LENGTH) {
                $ret = false;
            }
        }
        
        return $ret;
    }
}
