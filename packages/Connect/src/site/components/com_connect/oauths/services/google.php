<?php
/**
 * Authenticate agains Google service
 * 
 * @category   Anahita
 * @package    Com_Connect
 * @subpackage OAuth_Service
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComConnectOauthServiceGoogle extends ComConnectOauthServiceAbstract
{
    /**
     * Initializes the options for the object
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param   object  An optional KConfig object with configuration options.
     * @return  void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'readonly'          => true,
            'service_name'      => 'Google',
            'api_url'           => 'https://www.googleapis.com/oauth2/v1',
            'request_token_url' => 'https://www.google.com/accounts/OAuthGetRequestToken',
            'authorize_url'     => 'https://www.google.com/accounts/OAuthAuthorizeToken',
            'access_token_url'  => 'https://www.google.com/accounts/OAuthGetAccessToken',
        ));
        
        parent::_initialize($config);
    }
    
    /**
     * Get the access token using an authorized request token
     * 
     * @param array $data 
     * @return string
     */
    public function requestAdccessToken($data)
    {
        $post = array(
            'client_id'     => $this->_consumer->key,
            'client_secret' => $this->_consumer->secret,
            'code'          => $data->code,
            'redirect_uri'  => $this->_consumer->callback_url,
            'grant_type'    => 'authorization_code',
        );
        $response = $this->getRequest(array('url' => $this->access_token_url, 'method' => KHttpRequest::POST, 'data' => $post))->send();
        $result   = $response->parseJSON();
        $this->setToken($result->access_token);
        return $result->access_token;
    }
    
    /**
     * @inheritDoc
     */
    public function canAddService($actor)
    {
        return $actor->inherits('ComPeopleDomainEntityPerson');
    }
    
    /**
     * Implements an empty post message. Google is a readyonly service
     * 
     * @return void
     */
    public function postUpdate($message)
    {
        //Do nothing
    }
    
    /**
    * Return the current user data
    * 
    * @return array
    */
    protected function _getUserData()
    {
        $profile = $this->get('userinfo');
        $data = array(
            'id'           => $profile->id ,
            'profile_url'  => $profile->link,
            'name'         => $profile->name,
            'large_avatar' => $profile->picture,
            'thumb_avatar' => $profile->picture,
        );
        
        return $data;
    }
    
    /**
     * Request for a request token.
     * 
     * @param  array $data
     * @return string
     */
    public function requestRequestToken($data = array())
    {
        $data['scope'] = 'https://www.googleapis.com/auth/userinfo.profile';
        return parent::requestRequestToken($data);
    }
}
