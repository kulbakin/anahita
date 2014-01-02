<?php
/**
 * Query Helper Class
 * 
 * @category   Anahita
 * @package    Anahita_Domain
 * @subpackage Relationship
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class AnDomainQueryHelper
{
     /**
      * Applies an array of fiters to query by calling each filter as method
      * on the query 
      * 
      * @param AnDomainQuery $query   Query Object
      * @param array         $filters An array of filter
      * @return void
      */
     static public function applyFilters($query, $filters)
     {
         foreach ($filters as $filter => $value) {
             $method = KInflector::variablize($filter);
             $value  = KConfig::unbox($value);
             if ( ! is_array($value) || ! is_numeric(key($value))) {
                 $args = array($value);
             } else {
                 $args = $value;
             }
             call_object_method($query, $method, $args);
         }
     }
     
    /**
     * Return the column name of a property. If property not exists just return $name
     * 
     * @param $query
     * @param $columns
     * @return array 
     */
    static public function parseColumns($query, $columns)
    {
        if ($columns instanceof AnDomainResourceColumn) {
            return array($columns);
        }
        
        settype($columns, 'array');
        $array = array();
        foreach($columns as $key => $column) {
             $result = strpos($column, ' ') !== false ? null : AnDomainQueryHelper::parseColumn($query, $column);
             $cols   = $result['columns'];
             if ( ! isset($result['property'])) {
                  $array[$key] = $column;
             } elseif ( ! is_array($cols)) {
                  $array[$key] = $cols;
             } else {
                 $key = 10000;
                 foreach ($cols as $col) {
                     $array[$key++] = $col;
                 }
             }
        }
        return $array;
    }
    
    /**
     * Return a property object from a key value 
     * 
     * @param AnDomainQuery $query  Query Object
     * @param string        $column Column name
     * @return AnDomainPropertyAbstract
     */
    static public function parseColumn($query, $column)
    {
        $repository     = $query->getRepository();
        $description    = $repository->getDescription();
        $parts          = explode('.', $column, 2);
        $attribute      = isset($parts[1]) ? $parts[1] : null;
        $result         = array('columns' => null, 'property' => null);
        
        // don't check the parent properties
        if ($property = $description->getProperty($parts[0], false)) {
            if ($property->isAttribute()) {
                $result['property'] = $property; 
                $result['columns']  = $property->getColumn();
            } elseif ($property->isRelationship()) {
                if ($property->isManyToOne()) {
                    // join the query for the belongs to relationship
                    $result['columns']  = $columns = $property->getColumns();
                    $result['property'] = $property;
                    if ($attribute && isset($columns[$attribute])) {
                        $result['columns'] = $columns[$attribute];
                    } elseif ($attribute) {
                        $result = self::_parseManyToOne($query, $property, $attribute, $parts[0]);
                    }
                } elseif ($property->isManyToMany()) {
                    $result = self::_parseManyToMany($query, $property, $attribute, $parts[0]);    
                    if ( ! $attribute) {
                        $result['columns'] = array();
                    }
                } elseif ($property->isOneToMany()) {
                    $result = self::_parseOneToMany($query, $property, $attribute, $parts[0]);                            
                }
                
                return $result;
            }
        } elseif (isset($query->link[$parts[0]])) {
            $query  = $query->link[$parts[0]]['query'];
            $result = self::parseColumn($query, $parts[1]);
        }
        return $result;
    }
    
    /**
     * Adds a relationship to query
     * 
     * @param AnDomainQuery $query        Query Object
     * @param string        $relationship Relationship name
     * @return void
     */
    static public function addRelationship($query, $relationship)
    {
        $property = $query->getRepository()->getDescription()->getProperty($relationship);
        
        if ($property->isManyToOne()) {
            return self::_parseManyToOne($query, $property);
        } elseif ($property->isManyToMany()) {
            return self::_parseManyToMany($query, $property);
        } elseif ($property->isOneToMany()) {
            return self::_parseOneToMany($query, $property);
        }
    }
    
    /**
     * Parses many to one 
     */
    static public function _parseManyToOne($query, $relationship, $attribute = null, $as = null)
    {
        $columns = $relationship->getColumns();
        
        if ( ! $relationship->getParent()) {
            throw new AnDomainQueryException('Query Building Failed. Unkown Parent');                
        } elseif($relationship->isPolymorphic()) {
            reset($columns);
            $columns = array(key($columns) => current($columns));
        }
        
        $parent       = $relationship->getParentRepository();
        $parent_query = $parent->getQuery();
        $condition    = array();
        
        foreach($columns as $parent_property => $child_column) {
            $result = self::parseColumn($parent_query, $parent_property);
            $condition[(string)$child_column] = $result['columns'];
        }
        
        if ( ! $as) {
            $as = $relationship->getName();
        }
        $query->link($parent_query, $condition, array('as' => $as));
        
        if ($attribute) {
            return self::parseColumn($parent_query, $attribute);
        }
    }
    
    /**
     * Parses many to one 
     */
    static public function _parseOneToMany($query, $relationship, $attribute = null, $as = null)
    {
        $child          = $relationship->getChildRepository();
        $child_query    = $child->getQuery();
        $child_belongs_to_property = $child->getDescription()->getProperty($relationship->getChildkey());
        $columns        = $child_belongs_to_property->getColumns();
        // if the relationship parent is not set then throw an error
        // if polymorphic with a base parent just use the id
        if ( ! $child_belongs_to_property->getParent()) {
            throw new AnDomainQueryException('Query Building Failed. Unkown Parent');
        } elseif ($child_belongs_to_property->isPolymorphic()) {
            list($k) = array_keys($columns);
            $columns = array($k => $columns[$k]);
        }
        
        $condition = array();
        foreach ($columns as $parent_property => $child_column) {
            $result = self::parseColumn($query, $parent_property);
            $col    = $result['columns'];
            $condition[(string)$col] = $child_column;
        }
        
        if ( ! $as) {
            $as = $relationship->getName();
        }
        $query->link($child_query, $condition, array('as' => $as));
        
        if ($attribute) {
            return self::parseColumn($child_query, $attribute);
        }
    }
    
    /**
     * Parses many to one 
     */
    static public function _parseManyToMany($query, $relationship, $attribute = null, $as = null)
    {
        $child          = $relationship->getChildRepository();
        $child_query    = $child->getQuery();
        $child_belongs_to_property = $child->getDescription()->getProperty($relationship->getChildkey());
        $columns        = $child_belongs_to_property->getColumns();
        // if the relationship parent is not set then throw an error
        // if polymorphic with a base parent just use the id
        if ( ! $child_belongs_to_property->getParent()) {
            throw new AnDomainQueryException('Query Building Failed. Unkown Parent');
        } elseif ($child_belongs_to_property->isPolymorphic()) {
            list($key, ) = array_keys($columns);
            $columns = array($key => $columns[$key]);
        }
        
        $condition = array();
        foreach ($columns as $parent_property => $child_column) {
            $result = self::parseColumn($query, $parent_property);
            $col    = $result['columns'];
            $condition[(string)$col] = $child_column;
        }
        
        if ( ! $as) {
            $as = $relationship->getJunctionAlias();
        }
        $query->link($child_query, $condition, array('as' => $as));
        
        if ($relationship->getTargetParentKey() == $attribute) {
            $attribute = $relationship->getTargetChildKey().'.'.$attribute;
            $result = self::parseColumn($child_query, $attribute);
            return $result;
        } else {
            $property = $child->getDescription()->getProperty($relationship->getTargetChildKey());
            return self::_parseManyToOne($query, $property, $attribute, $relationship->getName());
        }
    }
}