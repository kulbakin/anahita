<?php
/**
 * Dashboard HTML View
 * 
 * @category   Anahita
 * @package    Com_Dashboard
 * @subpackage View
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComDashboardViewDashboardHtml extends ComBaseViewHtml
{
    /**
     * Prepare default layout
     * 
     * @return void
     */
    protected function _layoutDefault()
    {
        $this->set('gadgets',   new LibBaseTemplateObjectContainer());
        $this->set('composers', new LibBaseTemplateObjectContainer());
        $context = new KCommandContext();
        $context->actor     = $this->viewer;
        $context->gadgets   = $this->gadgets;
        $context->composers = $this->composers;
        
        // make all the apps to listen to dispatcher
        $components = $this->getService('repos://site/components.component')->fetchSet();
        $components->registerEventDispatcher($this->getService('anahita:event.dispatcher'));
        
        $this->getService('anahita:event.dispatcher')->dispatchEvent('onDashboardDisplay', $context);
    }
}
