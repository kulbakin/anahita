<?php
/**
 * Subscription Controller
 * 
 * @category   Anahita
 * @package    Com_Subscriptions
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComSubscriptionsControllerSubscription extends ComBaseControllerService
{
    /**
     * Add a package
     * 
     * @param KCommandContext $context
     * @return void
     */
    protected function _actionAdd(KCommandContext $context)
    {
        $data = $context->data;
        $data->person = $this->getService('repos://admin/subscriptions.person')->fetch(array('userId'=>$data->user_id));
        $package      = $this->getService('repos://admin/subscriptions.package')->find($data->package_id);
        
        if ( ! $package) {
            return false;
        }
        $data->person->subscribeTo($package);
    }
    
    /**
     * Deletes the person subscription
     * 
     * @param KCommandContext $context
     * @return void
     */
    protected function _actionDelete(KCommandContext $context)
    {
        $data = $context->data;
        $data->person = $this->getService('repos://admin/subscriptions.person')->fetch(array('userId'=>$data->user_id));
        $package      = $this->getService('repos://admin/subscriptions.package');
        $data->person->unsubscribe();
    }
    
    /**
     * Add a package
     * 
     * @param KCommandContext $context
     * @return void
     */
    protected function _actionEdit(KCommandContext $context)
    {
        $data = $context->data;
        $data->subscription->endDate = $data->end_date;
    }
}
