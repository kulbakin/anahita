<?php

/**
 * Enableable Behavior
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Controller_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3
 */
class ComBaseControllerBehaviorEnableable extends KControllerBehaviorAbstract
{
    /**
     * Check if Enable action is allowed to the viewer
     * 
     * @return bool
     */
    public function canEnable()
    {
        return $this->getItem()->authroize('administration');
    }
    
    /**
     * Check if Disable action is allowed to the viewer
     * 
     * @return bool
     */
    public function canDisable()
    {
        return $this->getItem()->authroize('administration');
    }
    
    /**
     * Enable Entity
     * 
     * @param KCommandContext $context
     * @return void
     */
    protected function _actionEnable($context)
    {
        $context->response->status = KHttpResponse::RESET_CONTENT;
        $this->getItem()->enabled = 1;
        return $this->getItem();
    }
    
    /**
     * Disable Entity
     * 
     * @param KCommandContext $context
     * @return void
     */
    protected function _actionDisable($context)
    {
        $context->response->status = KHttpResponse::RESET_CONTENT;
        $this->getItem()->enabled = 0;
        return $this->getItem();
    }
}