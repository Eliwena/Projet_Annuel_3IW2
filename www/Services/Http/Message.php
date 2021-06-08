<?php

namespace App\Services\Http;

class Message {

    public static function create(string $title, string $message, $type = 'error') {
        $session = 'message.' . $type;
        if(Session::exist($session)) {
            $message = Session::load($session);
            $messages = array_push($message, [['title' => $title, 'message' => $message]]);
            Session::create($session, $messages);
        } else {
            Session::create($session, [['title' => $title, 'message' => $message]]);
        }
    }

}