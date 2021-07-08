<?php

namespace App\Services\Http;

class Message {

    public static function create(string $title, string $message, $type = 'error') {
        $session = 'message';
        if(Session::exist($session)) {
            $message = Session::load($session);
            $messages = array_merge($message[$type], [['title' => $title, 'message' => $message]]);
            Session::create($session, $messages);
        } else {
            Session::create($session, [$type => ['title' => $title, 'message' => $message]]);
        }
    }

}