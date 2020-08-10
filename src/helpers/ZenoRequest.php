<?php
/**
 * ZenoResponse - Basic class to manage output to the browser
 *
 * @package Zeno
 * @copyright 2019 Salespoint Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace app\helpers;

class ZenoRequest
{

    //==============================================================================

    //define some quick formatting types (some of these also allow limited auto-formatting functionality)
    const FORMAT_PLAINTEXT = 'text/plain';
    const FORMAT_FORMDATA  = 'application/x-www-form-urlencoded';
    const FORMAT_JSON      = 'application/json';
    const FORMAT_XML       = 'application/xml';

    //==============================================================================

    //
    private $baseuri     = null;
    private $options     = null;

    //
    private $username    = null;
    private $password    = null;

    //
    private $endpoint    = null;
    private $headers     = null;
    private $request     = null;
    private $response    = null;
    private $information = null;

    /**
     * [__construct description]
     * @param [type] $baseuri  [description]
     * @param array  $options  [description]
     */
    public function __construct($baseuri, $options = []) {
        $this->baseuri  = $baseuri;
        $this->options  = $options;
    }

    //==============================================================================

    /**
     * [setBasicAuthorisation description]
     * @param [type] $username [description]
     * @param [type] $password [description]
     */
    public function setBasicAuthorisation($username, $password) {
        $this->username = $username;
        $this->password = $password;
        return $this;
    }

    //==============================================================================

    /**
     * [getOptions description]
     * @return [type] [description]
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * [setOptions description]
     * @param [type] $options [description]
     */
    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }

    //==============================================================================

    /**
     * [request description]
     * @param  [type] $method   [description]
     * @param  [type] $endpoint [description]
     * @param  [type] $payload  [description]
     * @return [type]           [description]
     */
    public function request($method, $endpoint, $payload = null) {
        return $this->execute($method, $endpoint, ZenoRequest::FORMAT_JSON, $payload);
    }

    //==============================================================================

    /**
     * [execute description]
     * @param  [type] $method   [description]
     * @param  [type] $endpoint [description]
     * @param  [type] $format   [description]
     * @param  [type] $payload  [description]
     * @return [type]           [description]
     */
    public function execute($method, $endpoint, $contentType = null, $payload = null) {

        //------------------------------------------------------------------------------

        //initialise the curl connection resource
        $curl = curl_init();

        //------------------------------------------------------------------------------

        //should we attach the "payload" to the body of the request
        if (in_array(strtoupper($method), ['POST', 'PUT', 'DELETE', 'PATCH']) and $payload !== null) {

            //
            $this->request = $payload;

            //attempt to auto format the payload based on the requested content type
            if ($contentType == ZenoRequest::FORMAT_JSON and is_array($payload)) {
                $this->request = @json_encode($payload, JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK);
            }

            if ($contentType == ZenoRequest::FORMAT_FORMDATA and is_array($payload)) {
                $this->request = http_build_query($payload, '', '&');
            }

        }

        //------------------------------------------------------------------------------

        //if the content type has been provided, set that as a header, but allow it to be overridden by the existing header options
        if ($contentType !== null) {
            $this->options['CURLOPT_HTTPHEADER'] = array_merge(['Content-Type: ' . $contentType], (array) @$this->options['CURLOPT_HTTPHEADER']);
        }

        //apply the "authorisation" header if we have login details
        if ($this->username !== null and $this->password !== null) {
            $this->options['CURLOPT_HTTPHEADER'] = array_merge(['Authorization: Basic ' . base64_encode(sprintf('%1$s:%2$s', $this->username, $this->password))], (array) @$this->options['CURLOPT_HTTPHEADER']);
        }

        //apply any general "curl" options that have been submitted in our option data
        foreach ($this->getOptions() as $name => $value) {
            if (stripos($name, 'CURLOPT_') !== false) {
                curl_setopt($curl, ((is_string($name)) ? constant(strtoupper($name)) : $name), $value);
            }
        }

        //------------------------------------------------------------------------------

        //ask for request headers to be included in the response from curl_getinfo
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);

        //add a process for getting the response headers
        curl_setopt($curl, CURLOPT_HEADERFUNCTION, function($curl, $header) {
            if (strlen(trim($header)) > 2) {
                $this->headers[] = trim($header);
            }
            return strlen($header);
        });

        //------------------------------------------------------------------------------

        //build the endpoint url 
        $this->endpoint = $this->baseuri . $endpoint;

        //attach the request body and set the request method to "post"
        if (strtoupper($method) == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->request);
        }

        //
        curl_setopt($curl, CURLOPT_URL, $this->endpoint);

        //
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        //retrieve the response
        $this->response    = curl_exec($curl);
        $this->information = curl_getinfo($curl);

        //
        if (curl_error($curl) != '')  {
            throw new ZenoRequestException($this, 'There was an error processing the request, the error was "{curlerrormsg}"', array(
                'curlerrorno'  => curl_errno($curl),
                'curlerrormsg' => curl_error($curl),
            ));
        }

        //close down the curl connection
        curl_close($curl);

        //
        return $this;

    }

    //==============================================================================

    /**
     * [getendpoint description]
     * @return [type] [description]
     */
    public function getEndpoint() {
        return $this->endpoint;
    }

    /**
     * [getRequest description]
     * @return [type] [description]
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * [getResponse description]
     * @return [type] [description]
     */
    public function getResponse($format = 'detect') {

        //should we try to auto-detect the format
        if ($format == 'detect' and array_key_exists('content_type', $this->getInformation())) {
            list($format) = explode(';', trim($this->getInformation()['content_type'], 2));
        }

        //
        if ($format == self::FORMAT_JSON) {
            return json_decode($this->response, true);
        }

        //
        if ($format == self::FORMAT_FORMDATA) {
            return @http_parse_query($this->response);
        }

        //
        return $this->response;

    }

    /**
     * [getInformation description]
     * @return [type] [description]
     */
    public function getInformation() {
        return $this->information;
    }

    //==============================================================================

    /**
     * [getRequestHeaders description]
     * @return [type] [description]
     */
    public function getRequestHeaders() {
        if (array_key_exists('request_header', $this->getInformation())) {
            foreach (explode("\n", $this->getInformation()['request_header']) as $header) {
                if (strlen(trim($header)) > 2) {
                    $headers[] = trim($header);
                }
            }
            return (array) @$headers;
        }
        return null;
    }

    /**
     * [getResponseHeaders description]
     * @return [type] [description]
     */
    public function getResponseHeaders() {
        return $this->headers;
    }

    //==============================================================================

    /**
     * [getResponseHeaders description]
     * @return [type] [description]
     */
    public function getRequestStatus() {
        if (array_key_exists('http_code', $this->getInformation())) {
            return $this->getInformation()['http_code'];
        }
        return null;
    }

    /**
     * [getResponseHeaders description]
     * @return [type] [description]
     */
    public function getRequestDuration() {
        if (array_key_exists('total_time', $this->getInformation())) {
            return $this->getInformation()['total_time'];
        }
        return null;
    }

    //==============================================================================

}