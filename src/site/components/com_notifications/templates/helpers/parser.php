<?php
/**
 * Template Helper
 * 
 * @category   Com_Notifications
 * @package    Site
 * @subpackage Template
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  Copyright (C) 2008 - 2010 rmdStudio Inc. and Peerglobe Technology Inc. All rights reserved.
 * @author     Arash Sanieyan
 */
class ComNotificationsTemplateHelperParser extends ComStoriesTemplateHelperParser
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
            'filters' => array(
                'com://site/notifications.template.filter.blockquote',
                'com://site/notifications.template.filter.link',
            )
        ));
        
        parent::_initialize($config);
    }
}
