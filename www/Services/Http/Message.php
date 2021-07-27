<?php

namespace App\Services\Http;

use App\Core\Helpers;

class Message {

    /**
     * @param string $title
     * @param string $message
     * @param string $type
     * create a session message with title message and type
     */
    public static function create(string $title, string $message, $type = 'error') {
        Session::push('message', [['title' => $title, 'message' => $message, 'type' => $type]]);
        session_write_close();
    }

}