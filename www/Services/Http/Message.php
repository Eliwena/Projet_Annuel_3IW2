<?php

namespace App\Services\Http;

use App\Core\Helpers;

class Message {

    public static function create(string $title, string $message, $type = 'error') {
        Session::push('message', [['title' => $title, 'message' => $message, 'type' => $type]]);
    }

}