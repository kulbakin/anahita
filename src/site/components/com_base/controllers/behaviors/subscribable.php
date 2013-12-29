<?php
/**
 * Subscribable Behavior
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Controller_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2011 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComBaseControllerBehaviorSubscribable extends KControllerBehaviorAbstract 
{
    /**
     * If the viewer is subscribe then unsubscribe, if not subscribe then subscribe
     * 
     * @param KCommandContext $context Context parameter
     * @return void
     */    
    protected function _actionTogglesubscription(KCommandContext $context)
    {
        if ($this->getItem()->subscribed(get_viewer())) {
            $ret = $this->_mixer->execute('unsubscribe', $context);
        } else {
            $ret= $this->_mixer->execute('subscribe', $context);
        }
        
        return $ret;
    }
    
    /**
     * Subscribe the viewer to the subscribable object
     * 
     * @param KCommandContext $context Context parameter
     * @return void
     */
    protected function _actionSubscribe(KCommandContext $context)
    {
        $this->getItem()->addSubscriber(get_viewer());
    }
    
    /**
     * Remove the viewer's subscription from the subscribable object
     * 
     * @param KCommandContext $context Context parameter
     * @return void
     */
    protected function _actionUnsubscribe(KCommandContext $context)
    {
        $this->getItem()->removeSubscriber(get_viewer());
    }
}
