<?php
/**
 * Html Transport
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Dispatcher_Response
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @copyright  2008 - 2011 rmdStudio Inc./Peerglobe Technology Inc
 */
class LibBaseDispatcherResponseTransportHtml extends LibBaseDispatcherResponseTransportAbstract
{
    /**
     * For all the success HTML responses unless its ajax, perform a redirect if the location
     * is set
     * 
     * (non-PHPdoc)
     * @see LibBaseDispatcherResponseTransportAbstract::sendHeaders()
     */
    public function sendHeaders()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();
        if (isset($headers['Location'])
            && $response->isSuccess()
            && ! $response->getRequest()->isAjax()
        ) {
            $response->setStatus(KHttpResponse::SEE_OTHER);
        }
        
        return parent::sendHeaders();
    }
}
