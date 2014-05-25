<?php
/**
* @package      Joomla
* @subpackage   JFramework
* @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license      GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * Joomla Authentication plugin
 * 
 * @package     Joomla
 * @subpackage  JFramework
 * @since 1.5
 */
class PlgAuthenticationConnect extends JPlugin
{
    /**
     * Authenticates a user using oauth_token,oauth_secret
     * 
     * @param   array   $credentials Array holding the user credentials
     * @param   array   $options     Array of extra options
     * @param   object  $response    Authentication response object
     * @return  boolean
     * @since 1.5
     */
    public function onAuthenticate(&$credentials, $options, &$response)
    {
        if (isset($credentials['username'])
            && isset($credentials['password'])
        ) {
            return;
        }
        if (isset($credentials['oauth_token'])
            && isset($credentials['oauth_handler'])
        ) {
            try {
                extract($credentials, EXTR_SKIP);
                
                // if oatuh secret not set then set it to null
                if (empty($oauth_secret)) {
                    $oauth_secret = '';
                }
                
                // lets get the api
                $api = ComConnectHelperApi::getApi($oauth_handler);
                $api->setToken($oauth_token, $oauth_secret);
                // if we can get the logged in user then
                // the user is authenticated
                if ($profile_id = $api->getUser()->id) {
                    // lets find a valid sesison
                    // lets be strict and make sure all the values match
                    $session = KService::get('repos://site/connect.session')
                        ->find(array(
                            'owner.type'  => 'com:people.domain.entity.person',
                            'profileId'   => $profile_id,
                            'tokenKey'    => $oauth_token,
                            'api'         => $oauth_handler,
                        ));
                    if ($session) {
                        $response->status = JAUTHENTICATE_STATUS_SUCCESS;
                        $response->username = $session->owner->username;
                        $response->password = ' ';
                        $response->fullname = ' ';
                    }
                }
            } catch(Exception $e) {
                // ignore any exception
            }
        }
    }
}
