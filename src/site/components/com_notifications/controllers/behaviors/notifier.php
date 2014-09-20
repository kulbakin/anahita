<?php
/**
 * Publisher Behavior. Publishes stories after an action
 * 
 * @category   Anahita
 * @package    Com_Notifications
 * @subpackage Controller_Behavior
 * @author     Pavel Kulbakin <p.kulbakin@gmail.com>
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComNotificationsControllerBehaviorNotifier extends KControllerBehaviorAbstract
{
    /**
     * Creates a notification
     * 
     * @param array $data Notification data
     * @return ComNotificationDomainEntityNotification
     */
    public function createNotification($data = array())
    {
        $data = new KConfig($data);
        
        $data->append(array(
            'component' => 'com_'.$this->_mixer->getIdentifier()->package,
            'subject'   => get_viewer(),
        ));
        
        $notification = $this->getService('repos:notifications.notification')->getEntity(array('data' => $data));
        $notification->removeSubscribers(get_viewer());
        
        return $notification;
    }
    
    /**
     * Created a notification sent to administrators
     * 
     * @param array $data Notification data
     * @return ComNotificationDomainEntityNotification
     */
    public function createAdminNotification($data = array())
    {
        $data = new KConfig($data);
        
        $adminIds = $this->getService('repos:people.person')->getQuery()
            ->where('userType', 'IN', array('Administrator', 'Super Administrator'))
            ->fetchValues('id');
        
        if ($adminIds) {
            return $this->createNotification($data->append(array(
                'subscribers' => $adminIds,
            )));
        }
        
        return null;
    }
}
