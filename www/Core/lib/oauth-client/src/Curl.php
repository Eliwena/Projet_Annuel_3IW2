<?php

namespace Mnt\OAuth;

class Curl
{

    private $url;
    private $options;
    private $cert_path;

    public function __construct($url, array $options = [])
    {
        $this->url = $url;
        $this->options = $options;
        $this->cert_path = realpath(dirname(__FILE__)) . '/cacert.pem';
    }

    public function exec(array $data = null, $use_cacert = true)
    {
        $ch = \curl_init($this->url);

        foreach ($this->options as $key => $val) {
            \curl_setopt($ch, $key, $val);
        }

        if($use_cacert) {
            \curl_setopt($ch, \CURLOPT_CAINFO, $this->cert_path);
            \curl_setopt($ch, \CURLOPT_CAPATH, $this->cert_path);
        }
        if(!is_null($data)) {
            \curl_setopt($ch, \CURLOPT_POSTFIELDS, $data);
        }
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch,\CURLOPT_CONNECTTIMEOUT ,3);
        \curl_setopt($ch,\CURLOPT_TIMEOUT, 10);

        $response = \curl_exec($ch);
        $error    = \curl_error($ch);
        $errno    = \curl_errno($ch);

        if (\is_resource($ch)) {
            \curl_close($ch);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }

        return $response;
    }
}