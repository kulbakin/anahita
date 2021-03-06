<?php
/**
 * Alias Filter
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Template_Filter
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComBaseTemplateFilterAlias extends LibBaseTemplateFilterAlias
{
    /**
     * Constructor.
     * 
     * @param object An optional KConfig object with configuration options
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);
        
        $this->_alias_read = array_merge($this->_alias_read, array(
            '@flash_message(' => '$this->renderHelper(\'ui.flash\',',
            '@flash_message'  => '$this->renderHelper(\'ui.flash\')',
            '@commands('      => '$this->getHelper(\'toolbar\')->commands(',
            '@content('       => 'PlgContentfilterChain::getInstance()->filter(',
            '@pagination('    => '$this->renderHelper(\'ui.pagination\',',
            '@avatar('        => '$this->renderHelper(\'com://site/actors.template.helper.avatar\',',
            '@name('          => '$this->renderHelper(\'com://site/actors.template.helper.name\',',
            '@editor('        => '$this->renderHelper(\'ui.editor\',',
            '@message('       => '$this->renderHelper(\'ui.message\',',
            '@date('          => '$this->renderHelper(\'date.format\',',
        ));
    }
}
