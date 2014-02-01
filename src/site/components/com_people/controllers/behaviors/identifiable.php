<?php
/**
 * Identifiable Behavior
 * 
 * @category   Anahita
 * @package    Com_People
 * @subpackage Controller_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2011 rmdStudio Inc./Peerglobe Technology Inc
 */
class ComPeopleControllerBehaviorIdentifiable extends ComBaseControllerBehaviorIdentifiable
{
    /**
     * (non-PHPdoc)
     * @see ComBaseControllerBehaviorIdentifiable::fetchEntity()
     */
    public function fetchEntity(KCommandContext $context)
    {
        if ($this->isDispatched()) {
            $username = $this->getRequest()->username;
            if ($username && $this->getRequest()->get('layout') != 'add') {
                $this->setIdentifiableKey('username');
            }
        }
        
        return parent::fetchEntity($context);
    }
}
