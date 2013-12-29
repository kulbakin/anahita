<?php
/**
 * Milestone Controller
 * 
 * @category   Anahita
 * @package       Com_Todos
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComTodosControllerMilestone extends ComMediumControllerDefault
{
    /**
     * Browse Milestones
     * 
     * @param KCommandContext $context
     * @return null;
     */
    protected function _actionBrowse(KCommandContext $context)
    {
        parent::_actionBrowse($context)->order('endDate', 'DESC');
    }
}
