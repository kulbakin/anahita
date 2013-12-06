<?php

/**
 * Page Controller
 * 
 * @category   Anahita
 * @package    Com_pages
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3
 */
class ComPagesControllerPage extends ComMediumControllerDefault
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
            'request' => array(
                'sort' => 'creationTime',
                'direction' => 'desc',
            ),
            'behaviors' => array(
                'enablable',
            ),
        ));
        
        parent::_initialize($config);
    }
}