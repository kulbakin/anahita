<?php
/**
 * Composer UI Helper
 * 
 * @category   Anahita
 * @package    Com_Composer
 * @subpackage Template
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComComposerTemplateHelperUi extends ComBaseTemplateHelperUi
{
    /**
     * Initializes the options for the object
     * 
     * Called from {@link __construct()} as a first step of object instantiation.
     * 
     * @param  object An optional KConfig object with configuration options.
     * @return void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'paths' => array(dirname(__FILE__).'/ui'),
        ));
        
        parent::_initialize($config);
    }
}
