<?php
if (!defined('ABSPATH'))
{
   exit();
}



/**
 * Class Message
 *
 * @package pimax\Messages
 */
class Der_Weili_Message extends pimax\Messages\Message
{

    /**
     * @var false|boolean
     */
    protected $is_reference = null;
    /**
     * @var array
     */
    protected $get_data_return = array();

    protected $recipient_type = 'id';

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $text
     */
    public function __construct($recipient, $text, $is_reference = false)
    {
        $this->recipient = $recipient;
        $this->text = $text;
        $this->is_reference = $is_reference;
        if( $is_reference ) $this->$recipient_type = 'user_ref';
        var_dump( $is_reference );

    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {   
        $this->get_data_return['message'] = [
                'text' => $this->text
            ];

        /*if ( $this->is_reference ) {
            $this->get_data_return['recipient'] = [
                'user_ref' => $this->recipient
            ];
        }else{
            $this->get_data_return['recipient'] = [
                'id' => $this->recipient
            ];
        }*/

        /*$this->get_data_return['recipient'] = [
            $this->$recipient_type => $this->recipient
        ];*/

        $this->get_data_return['recipient'] = array();
        $this->get_data_return['recipient'][$this->$recipient_type] = $this->recipient;


        //var_dump( $this->get_data_return );


        return $this->get_data_return;

    }

    /**
     * @param string $filename
     * @param string $contentType
     * @param string $postname
     * @return \CURLFile|string
     */
    protected function getCurlValue($filename, $contentType, $postname)
    {
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $contentType, $postname);
        }

        // Use the old style if using an older version of PHP
        $value = "@{$this->filename};filename=" . $postname;
        if ($contentType) {
            $value .= ';type=' . $contentType;
        }

        return $value;
    }
}