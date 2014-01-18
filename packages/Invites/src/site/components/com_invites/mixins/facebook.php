<?php
/**
 * Set of people who are an actor fb friends
 * 
 * @category   Anahita
 * @package    Com_Invites
 * @subpackage Mixins
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComInvitesMixinFacebook extends KMixinAbstract
{
    /**
     * Return the APPID
     * 
     * @return int
     */
    public function getAppID()
    {
        $key   = md5($this->_mixer->getToken());
        $cache = JFactory::getCache('ComInvitesMixinFacebook');
        $cache->setLifeTime(5 * 1000);
        $data = $cache->get(function ($session) {
            $info = $session->get('/app');
            return $info;
        }, array($this->_mixer), '/app'.$key);
        return $data['id'];
    }
    
    /**
     * Return a set of people who are fb friends
     * 
     * @return set
     */
    public function getConnections()
    {
        $cache = JFactory::getCache('ComInvitesMixinFacebook', '');
        $key   = 'ids_'.md5($this->_mixer->getToken());
        $data  = $cache->get($key);
        if ( ! $data) {
            try {
                $data = $this->_mixer->get('/me/friends');
            } catch(Exception $e) {
                throw new \LogicException("Can't get connections from facebook");
            }
            if ($data->error) {
                throw new \LogicException("Can't get connections from facebook");
            }
            $data = KConfig::unbox($data);
            $data = array_map(function ($user) {
                return $user['id'];
            }, $data['data']);
            $data[] = '-1'; 
            $cache->store(json_encode($data), $key);
        } else {
            $data = json_decode($data);
        }
        
        $query = $this->getService('repos://site/people')->getQuery(true)
            ->where(array(
                'sessions.profileId' => $data,
                'sessions.api'       => 'facebook',
            ));
        return $query->toEntitySet();
    }
}
