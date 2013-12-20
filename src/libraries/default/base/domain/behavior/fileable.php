<?php
/**
 * Fileable Behavior
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Domain_Behavior
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class LibBaseDomainBehaviorFileable extends LibBaseDomainBehaviorStorable
{
    /**
     * Initializes the default configuration for the object
     * 
     * Called from {@link __construct()} as a first step of object instantiation.
     * 
     * @param KConfig $config An optional KConfig object with configuration options.
     * @return void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'attributes' => array(
                'filename' => array('write' => 'private'),
                'filesize' => array('type' => 'integer', 'write' => 'private'),
                'mimetype' => array('match' => '/\S+\/\S+/', 'write' => 'private'),
            )
        ));
        
        parent::_initialize($config);
    }
    
    /**
     * Store Data
     * 
     * @param   array|KConfig $file
     * @return  void
     */
    public function storeFile($file)
    {
        $filename = md5($this->id);
        $data     = file_get_contents($file->tmp_name);
        $file->append(array(
            'type' => mime_type($file->name)
        ));
        
        $this->setData(array(
            'filename' => $file->name,
            'mimetype' => $file->type,
            'filesize' => strlen($data),
        ), AnDomain::ACCESS_PRIVATE);
        
        return $this->writeData($filename, $data, false);
    }
    
    /**
     * Return the file content;
     * 
     * @return string
     */
    public function getFileContent()
    {
        $filename = md5($this->id);
        return $this->readData($filename, false);
    }
}
