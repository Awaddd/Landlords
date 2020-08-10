<?php
/**
 * Zeno Request Exception
 *
 * @package Zeno
 * @copyright 2019 Richard Smith
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace app\helpers;

class ZenoRequestException extends ZenoGenericException
{
    //------------------------------------------------------------------------------

    //
    protected $request = null;

    //------------------------------------------------------------------------------

    /**
     * [__construct description]
     * @param [type] $request [description]
     * @param [type] $message [description]
     * @param array  $context [description]
     */
    public function __construct($request = null, $message, $context = []) {
        parent::__construct($message, $context);
        $this->request = $request;
    }

    //------------------------------------------------------------------------------
    
    /**
     * Get a block of HTML that will be suitable for the error reporting system
     * @return [type] [description]
     */
    public function getErrorReportHTML() {

        //
        $error_html[] = '<h4>Request Headers</h4><div><pre>'  . json_encode($this->request->getRequestHeaders(), JSON_PRETTY_PRINT)  . '</pre></div>';
        $error_html[] = '<h4>Request</h4><div><pre>'          . $this->request->getRequest(ZenoRequest::FORMAT_PLAINTEXT)            . '</pre></div>';
        $error_html[] = '<h4>Response Headers</h4><div><pre>' . json_encode($this->request->getResponseHeaders(), JSON_PRETTY_PRINT) . '</pre></div>';
        $error_html[] = '<h4>Response</h4><div><pre>'         . $this->request->getResponse(ZenoRequest::FORMAT_PLAINTEXT)           . '</pre></div>';
        $error_html[] = '<h4>Request Duration</h4><div><pre>' . json_encode($this->request->getRequestDuration(), JSON_PRETTY_PRINT) . '</pre></div>';

        //
        return implode('', $error_html);

    }

    //------------------------------------------------------------------------------

}