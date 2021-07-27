<?php

namespace App\Services\User;

use App\Services\Http\Session;

require '../Core/lib/oauth-client/src/Curl.php';
require '../Core/lib/oauth-client/src/OAuth.php';

class OAuth {

    /**
     * @var
     */
    private $oauth;

    /**
     * @var string[]
     */
    private $accepted_client = [
        'google',
        'facebook'
    ];

    /**
     * @var array
     */
    private $oauth_google_params = [
        'clientId'                => '1023879957584-mmm7rhg67e9d6d7kkfrk6k1fatgv47gf.apps.googleusercontent.com',
        'clientSecret'            => 'kpTY1smO4uRdJNPN0TqBfnLK',
        'redirectUri'             => 'http://localhost/login/oauth?client=google',
        'authorizationEndpoint'   => 'https://accounts.google.com/o/oauth2/v2/auth',
        'accessTokenEndpoint'     => "https://oauth2.googleapis.com/token",
        'userInfoEndpoint'        => 'https://openidconnect.googleapis.com/v1/userinfo',
        'scope'                   => ['openid', 'email', 'profile'],
    ];

    /**
     * @var array
     */
    private $oauth_facebook_params = [
        'clientId'                => '2986752281580944',
        'clientSecret'            => 'bce922a7d869845c136b3010b914df46',
        'redirectUri'             => 'http://localhost/login/oauth?client=facebook',
        'authorizationEndpoint'   => 'https://www.facebook.com/v11.0/dialog/oauth',
        'accessTokenEndpoint'     => "https://graph.facebook.com/v11.0/oauth/access_token",
        'userInfoEndpoint'        => 'https://graph.facebook.com/me',
        'scope'                   => ['email'],
    ];

    public function prepare() {
        $this->oauth = new \Mnt\OAuth\OAuth($this->getOAuth());
    }

    /**
     * @param $oauth_params
     */
    public function setOAuth($oauth_params) {
        $this->oauth = $oauth_params;
    }

    /**
     * @return mixed
     */
    public function getOAuth() {
        return $this->oauth;
    }

    /**
     * @return string[]
     */
    public function getAcceptedClient() {
        return $this->accepted_client;
    }

    /**
     * @return array
     */
    public function getGoogleParams() {
        return $this->oauth_google_params;
    }

    /**
     * @return array
     */
    public function getFacebookParams() {
        return $this->oauth_facebook_params;
    }

}