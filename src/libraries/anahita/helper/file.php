<?php
/**
 * File, Path Helpers
 * 
 * @category   Anahita
 * @package    Anahita_Helper
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 */
class AnHelperFile extends KObject
{
    /**
     * Return the travel path between two file paths (relative path)
     * 
     * @param string $from The starting path
     * @param string $to   The the end path
     * 
     * @return string
     */
    static public function getTravelPath($from, $to)
    {
        $from = explode(DS, str_replace(array('/', '\\'), DS, $from));
        $to   = explode(DS, str_replace(array('/', '\\'), DS, $to));
        
        $relPath  = $to;
        
        foreach($from as $depth => $dir) {
            // find first non-matching dir
            if($dir === $to[$depth]) {
                // ignore this directory
                array_shift($relPath);
            } else {
                // get number of remaining dirs to $from
                $remaining = count($from) - ($depth - 1);
                if($remaining > 1) {
                    // add traversals up to first matching dir
                    $padLength = (count($relPath) + $remaining - 1) * -1;
                    $relPath = array_pad($relPath, $padLength, '..');
                    break;
                } else {
                    $relPath[0] = './'.$relPath[0];
                }
            }
        }
        return implode('/', $relPath);
    }
}
