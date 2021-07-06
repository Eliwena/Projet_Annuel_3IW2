<?php

namespace App\Services\User;

use App\Services\Http\Session;

require '../Core/lib/oauth-client/src/Curl.php';
require '../Core/lib/oauth-client/src/OAuth.php';

class OAuth {

    private $oauth;

    public function __construct($params) {
        Session::init();
        $this->oauth = new \Mnt\OAuth\OAuth($params);
    }

    public function getOAuth() {
        return $this->oauth;
    }

}