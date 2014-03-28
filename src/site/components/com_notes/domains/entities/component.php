<?php
/**
 * Component object
 *
 * @category   Anahita
 * @package    Com_Notes
 * @subpackage Domain_Entity
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComNotesDomainEntityComponent extends ComMediumDomainEntityComponent
{
    /**
     * Return max
     * 
     * @return int
     */
    public function getPriority()
    {
        return -PHP_INT_MAX;
    }
    
    /**
     * @{inheritdoc}
     */
    protected function _setComposers($actor, $composers, $mode)
    {
        if ($actor->authorize('action', 'com_notes:note:add')) {
            $composers->insert('notes', array(
                'title'       => JText::_('COM-NOTES-COMPOSER-NOTE'),
                'placeholder' => JText::_('COM-NOTES-COMPOSER-PLACEHOLDER'),
                'url'         => 'option=com_notes&layout=composer&view=note&oid='.$actor->id,
            ));
        }
    }
}
