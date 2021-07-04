<?php

namespace Mnt\OAuth;

use App\Core\Helpers;
use Mnt\OAuth\Curl;

//code by Anthony ARJONA fork from my github https://github.com/Mimso/oauth-client-php (projet SDK)
class OAuth {

    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $response_type;
    private $scope;

    private $authorizationEndpoint;
    private $accessTokenEndpoint;
    private $userInfoEndpoint;

    private $code;
    private $grant_type;
    private $token;
    private $resource;

    public function __construct($params) {
        $this->client_id             = $params['clientId'];
        $this->client_secret         = $params['clientSecret'];
        $this->redirect_uri          = $params['redirectUri'];

        $this->authorizationEndpoint = $params['authorizationEndpoint'];
        $this->accessTokenEndpoint   = $params['accessTokenEndpoint'];
        $this->userInfoEndpoint      = $params['userInfoEndpoint'];

        $this->scope                 = isset($params['scope']) ? $params['scope'] : ['email'];
        $this->response_type         = 'code';
        $this->grant_type            = 'authorization_code';
    }

    public function getAuthUrl() {
        return $this->authorizationEndpoint . '?response_type=' . $this->response_type . '&scope=' . $this->getScope() . '&client_id=' . $this->client_id . '&redirect_uri=' . $this->redirect_uri;
    }

    public function getToken($code) {
        try {
            $this->code = $code;
            $curl = new Curl($this->accessTokenEndpoint);
            $response = $curl->exec([
                'code'          => $this->code,
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'redirect_uri'  => $this->redirect_uri,
                'grant_type'    => $this->grant_type
            ]);
        } catch (\RuntimeException $exception) {
            Helpers::error($exception->getMessage());
        }

        $this->token = $response;
        return $this->token;
    }

    public function getResource($return_type_array = false) {
        try {
            $curl = new Curl($this->userInfoEndpoint, [CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $this->getAccessToken()]]);
            $this->resource = $curl->exec([]);
        } catch (\Exception $exception) {
            Helpers::error($exception->getMessage());
        }
        return $return_type_array ? json_decode($this->resource, true) : json_decode($this->resource);
    }

    private function getScope() {
        $this->scope = implode('%20', $this->scope);
        return $this->scope;
    }
    private function getAccessToken() {
        $token = json_decode($this->token);
        return $token->access_token;
    }

}