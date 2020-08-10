<?php
/**
 * Base exception class - add some useful functionality to the class
 *
 * @package Zeno
 * @copyright 2015 Richard Smith
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace app\helpers;

class ZenoGenericException extends Exception {

    //==============================================================================

    //define the http status code and message to be used by this exception
    protected $httpStatusCode    = 500;
    protected $httpStatusMessage = 'Internal Server Error';

    //==============================================================================

    protected $context = [];

    //==============================================================================

    /**
     * [__construct description]
     * @param [type] $message [description]
     * @param array  $context [description]
     */
    public function __construct($message, $context = []) {

        //update the message with values from the context array
        $message = preg_replace_callback('/{(.+?)}/', function ($matches) use ($context) {
            return ((array_key_exists($matches[1], $context)) ? $context[$matches[1]] : $matches[0]);
        }, $message);

        //store the context data for later
        $this->context = $context;

        //pass the updated message to the base exception class
        parent::__construct($message);

    }

    //==============================================================================

    /**
     * Get the name of the class
     * @return string
     */
    public function getErrorType() {
        return get_class($this);
    }

    /**
     * Get the name of the class
     * @return string
     */
    public function getErrorLevel() {
        return 'error';
    }

    //==============================================================================

    /**
     * [getContext description]
     * @return [type] [description]
     */
    public function getContext() {
        return $this->context;
    }

    //==============================================================================

    /**
     * Get a block of HTML that will be suitable for the error reporting system
     * @return [type] [description]
     */
    public function getErrorReportHTML() {

        //only output if context exists
        if (count($this->getContext()) == 0) {
            return '';
        }

        //
        $output[] = '<h4>Context</h4>';
        $output[] = '<div>';
        $output[] = '    <table>';
        $output[] = '       <thead>';
        $output[] = '           <tr>';
        $output[] = '               <th width="200">Label</th>';
        $output[] = '               <th>Value</th>';
        $output[] = '           </tr>';
        $output[] = '       </thead>';
        $output[] = '       <tbody>';

        foreach ($this->getContext() as $label => $value) {
            $output[] = '           <tr>';
            $output[] = '               <td>' . $label . '</td>';
            $output[] = '               <td>' . ZenoDebug::value($value) . '</td>';
            $output[] = '           </tr>';
        }

        $output[] = '       </tbody>';
        $output[] = '    </table>';
        $output[] = '</div>';

        //
        return implode('', $output);

    }

    //==============================================================================

    /**
     * Get the http status code this exception wants to use
     * @return integer
     */
    public function getHttpStatusCode() {
        return $this->httpStatusCode;
    }

    /**
     * Get the http status message this exception wants to use
     * @return string
     */
    public function getHttpStatusMessage() {
        return $this->httpStatusMessage;
    }

    //==============================================================================

    /**
     * Set the $code of the current exception
     * @param string $code Required - The new code for the current exception
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * Set the $message of the current exception
     * @param string $message Required - The new message for the current exception
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * Set the $file of the current exception
     * @param string $file Required - The new file for the current exception
     */
    public function setFile($file) {
        $this->file = $file;
        return $this;
    }

    /**
     * Set the $line of the current exception
     * @param string $line Required - The new line for the current exception
     */
    public function setLine($line) {
        $this->line = $line;
        return $this;
    }

    //==============================================================================

}