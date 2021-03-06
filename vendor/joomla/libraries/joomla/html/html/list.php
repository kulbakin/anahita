<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Utility class for creating different select lists
 *
 * @package      Joomla.Framework
 * @subpackage   HTML
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license      GNU/GPL, see LICENSE.php
 * @since        1.5
 */
class JHTMLList
{
    /**
     * Build the select list for access level
     */
    public static function accesslevel( &$row )
    {
        $db =& JFactory::getDBO();
        
        $query = 'SELECT id AS value, name AS text'
            . ' FROM #__groups'
            . ' ORDER BY id'
        ;
        $db->setQuery( $query );
        $groups = $db->loadObjectList();
        $access = JHTML::_('select.genericlist',   $groups, 'access', 'class="inputbox" size="3"', 'value', 'text', intval( $row->access ), '', 1 );
        
        return $access;
    }
    
    /**
     * Description
     * 
     * @param string SQL with ordering As value and 'name field' AS text
     * @param integer The length of the truncated headline
     * @since 1.5
     */
    public static function genericordering( $sql, $chop = '30' )
    {
        $db =& JFactory::getDBO();
        $order = array();
        $db->setQuery( $sql );
        if ( ! ($orders = $db->loadObjectList())) {
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            } else {
                $order[] = JHTML::_('select.option',  1, JText::_( 'first' ) );
                return $order;
            }
        }
        $order[] = JHTML::_('select.option',  0, '0 '. JText::_( 'first' ) );
        for ($i = 0, $n = count( $orders ); $i < $n; $i++) {
            if (JString::strlen($orders[$i]->text) > $chop) {
                $text = JString::substr($orders[$i]->text,0,$chop)."...";
            } else {
                $text = $orders[$i]->text;
            }
            
            $order[] = JHTML::_('select.option',  $orders[$i]->value, $orders[$i]->value.' ('.$text.')' );
        }
        $order[] = JHTML::_('select.option',  $orders[$i-1]->value+1, ($orders[$i-1]->value+1).' '. JText::_( 'last' ) );
        
        return $order;
    }
    
    /**
     * Build the select list for Ordering of a specified Table
     */
    public static function specificordering( &$row, $id, $query, $neworder = 0 )
    {
        $db =& JFactory::getDBO();
        
        if ($id) {
            $order = JHTML::_('list.genericordering',  $query );
            $ordering = JHTML::_('select.genericlist',   $order, 'ordering', 'class="inputbox" size="1"', 'value', 'text', intval( $row->ordering ) );
        } else {
            if ($neworder) {
                $text = JText::_( 'descNewItemsFirst' );
            } else {
                $text = JText::_( 'descNewItemsLast' );
            }
            $ordering = '<input type="hidden" name="ordering" value="'. $row->ordering .'" />'. $text;
        }
        return $ordering;
    }
    
    /**
     * Select list of active users
     */
    public static function users($name, $active, $nouser = 0, $javascript = NULL, $order = 'name', $reg = 1)
    {
        $db =& JFactory::getDBO();
        
        $and = '';
        if ($reg) {
            // does not include registered users in the list
            $and = ' AND gid > 18';
        }
        
        $query = 'SELECT id AS value, name AS text'
            . ' FROM #__users'
            . ' WHERE block = 0'
            . $and
            . ' ORDER BY '. $order
        ;
        $db->setQuery( $query );
        if ($nouser) {
            $users[] = JHTML::_('select.option',  '0', '- '. JText::_( 'No User' ) .' -' );
            $users = array_merge( $users, $db->loadObjectList() );
        } else {
            $users = $db->loadObjectList();
        }
        
        $users = JHTML::_('select.genericlist',   $users, $name, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
        
        return $users;
    }
    
    /**
     * Select list of positions - generally used for location of images
     */
    public static function positions( $name, $active = NULL, $javascript = NULL, $none = 1, $center = 1, $left = 1, $right = 1, $id = false )
    {
        if ( $none ) {
            $pos[] = JHTML::_('select.option',  '', JText::_( 'None' ) );
        }
        if ( $center ) {
            $pos[] = JHTML::_('select.option',  'center', JText::_( 'Center' ) );
        }
        if ( $left ) {
            $pos[] = JHTML::_('select.option',  'left', JText::_( 'Left' ) );
        }
        if ( $right ) {
            $pos[] = JHTML::_('select.option',  'right', JText::_( 'Right' ) );
        }
        
        $positions = JHTML::_('select.genericlist',   $pos, $name, 'class="inputbox" size="1"'. $javascript, 'value', 'text', $active, $id );
        
        return $positions;
    }
}
