<?php
/**
 * Term filter
 * 
 * @category   Anahita
 * @package    Anahita_Filter
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2014 rmdStudio Inc
 */
class AnFilterTerm extends KFilterAbstract
{
    /**
     * Validate a value
     * 
     * @param   scalar  Value to be validated
     * @return  bool    True when the variable is valid
     */
    protected function _validate($value)
    {
        return is_string($value) && preg_match('/\pL|[.#@\s-]/u', $value);
    }
    
    /**
     * Sanitize a value
     * 
     * @param   scalar  Value to be sanitized
     * @return  string
     */
    protected function _sanitize($value)
    {
        return trim(preg_replace('/(?![.#@\s-])\PL/u', '', $value));
    }
}
