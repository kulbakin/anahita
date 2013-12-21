<?php
/**
 * Password Helper
 * 
 * @category   Anahita
 * @package    Com_People
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPeopleTemplateHelperPassword extends KTemplateHelperAbstract
{
    /**
     * Renders a password input with the validation
     * 
     * @param boolean $required A boolean flag whether the password is required or not 
     * @return void
     */
    public function input($class = 'input-block-level', $required = true)
    {
        $validators = array(
            'validate-password',
        );
        if ($required) {
            array_unshift($validators, 'required', 'minLength:'.ComPeopleFilterPassword::$MIN_LENGTH);
        }
        
        return '<input data-validators="'.implode($validators, ' ').'" type="password" id="password" value="" name="password" class="'.$class.'" />';
    }
}
