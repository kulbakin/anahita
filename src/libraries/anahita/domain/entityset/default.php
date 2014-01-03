<?php
/**
 * A Queriable entityset. If no data is set then the queriable data
 * will wait until one of the iteration mehtod is called to load 
 * the data
 * 
 * @category   Anahita
 * @package    Anahita_Domain
 * @subpackage Entityset
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class AnDomainEntitysetDefault extends AnDomainEntityset
{
    /**
     * The query that represents this entity set
     * 
     * @var AnDomainQuery
     */
    protected $_set_query;
    
    /**
     * Revert the query back to the original
     * 
     * @return AnDomainQuery
     */
    public function reset()
    {
        $this->_set_query  = null;
        $this->_object_set = null;
        
        return $this;
    }
    
    /**
     * Return the entityset query. If $clone is passed it will return a clone instance of the entityset
     * query is returned
     * 
     * @param boolean $clone If set to true then it will return a new clone instance of entityset
     * @param boolean $disable_chain Disable the chain
     * @return AnDomainQuery
     */
    public function getQuery($clone = false, $disable_chain = false)
    {
        if ( ! isset($this->_set_query) || $clone) {
            if ($this->_query instanceof AnDomainQuery) {
                $query = clone $this->_query;
            } else {
                $query = $this->_repository->getQuery();
                AnDomainQueryHelper::applyFilters($query, $this->_query);
            }
            
            //if clone is set, then return the qury object 
            if  ($clone) {
                if ($disable_chain) {
                    $query->disableChain();
                }
                return $query;
            }
            //if not then set the entity query object
            $this->_set_query = $query;
        }
        
        return $this->_set_query;
    }
    
    /**
     * Return the total number of entities that match the entityset query
     * 
     * @return int
     */
    public function getTotal()
    {
        $query = clone $this->getQuery();
        $query->order = null;
        return (int)$query->fetchValue('count(*)');
    }
    
    /**
     * Returns the set limit
     * 
     * @return int
     */
    public function getLimit()
    {
        return $this->getQuery()->limit;
    }
    
    /**
     * Returns the set offset
     * 
     * @return int
     */
    public function getOffset()
    {
        return $this->getQuery()->offset;
    }
    
    /**
     * If the missed method is implemented by the query object then delegate the call to the query object
     * 
     * @see KObject::__call()
     */
    public function __call($method, $arguments = array())
    {
        $parts = KInflector::explode($method);
        
        if ($parts[0] == 'is' && isset($parts[1])) {
            return $this->_repository->hasBehavior(strtolower($parts[1]));
        }
        
        //forward a call to the query
        if (method_exists($this->getQuery(), $method) || ! $this->_repository->entityMethodExists($method)) {
            $result = call_object_method($this->getQuery(), $method, $arguments);
            if ($result instanceof AnDomainQuery) {
                $result = $this;
            }
        } else {
            $result = parent::__call($method, $arguments);
        }
        return $result;
    }
    
    /**
     * Count Data
     * 
     * @param booelan $load If the flag is set to on. If the qurey is set, it will
     *                      perform a count query instead of loading all the objects
     * @return int
     */
    public function count($load = true)
    {
        //if query is set, and the data is not loaded
        //lets use the query to get the count
        if ( ! $load && ! $this->loaded() && $this->getQuery()) {
            return (int)AnDomainQuery::getInstance($this->getRepository(), $this->getQuery())->fetchValue('count(*)');
        } else {
            $this->_loadData();
            return AnObjectSet::count();
        }
    }
    
    /**
     * Loads the data into the object set using the query if not already loaded
     * 
     * @return void
     */
    protected function _getData()
    {
        $data = $this->getRepository()->fetch($this->getQuery(), AnDomain::FETCH_ENTITY_LIST);
        return $data;
    }
    
    /**
     * Execute callback function on each item in the set
     * 
     * Function can be used to iterate through big entity sets in order to avoid to pull
     * entire set into memory, internally function use chunks of 100 records in such case
     * 
     * @param callback $callback Accepts single parameter to be an item from entity set
     * @param bool[optional] $load Whether to load set or iterate through entire one
     * @return int
     */
    public function each($callback, $load = true)
    {
        if ($load) {
            $this->_loadData();
            $set = $this;
        } else {
            $set = clone $this;
            $set->reset();
        }
        
        $limit = 100; $offset = 0; $result = 0;
        do {
            if ( ! $load) {
                $set->reset()->getQuery()->limit($limit, $offset);
                $offset += $limit;
            }
            foreach ($set as $item) {
                $result += (int)call_user_func($callback, $item);
            }
        } while ( ! $load and $set->count() == $limit);
        
        return $result;
    }
}
