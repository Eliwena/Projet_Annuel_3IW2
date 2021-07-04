<?php

namespace App\Services\Mailer;

require './Core/lib/PHPMailer/src/Exception.php';
require './Core/lib/PHPMailer/src/PHPMailer.php';

use App\Core\Helpers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    private $mail;
    private $from = 'no-reply@framework.fr';
    private $fromName = '';

    public function __construct($language = 'fr') {
        $this->mail = new PHPMailer(true); //init
        $this->mail->setLanguage($language, '../../Core/lib/PHPMailer/language/'); // lang
        $this->mail->isMail(); //PHPMail
    }

    public function prepare(string $sendTo, string $subject, string $message = null, string $replyTo = null,bool $isHTML = true, string ...$atachments): Mailer {
        $this->mail->isHTML($isHTML);                                  //Set email format to HTML
        $this->mail->setFrom($this->getFrom());
        !is_null($replyTo)  ? $this->mail->addReplyTo($replyTo) : $replyTo = null;
        $this->mail->addAddress($sendTo);
        $this->mail->Subject = $subject;
        if($isHTML) {
            $this->mail->msgHTML($message);
            $this->mail->AltBody = 'Please enable html or use client with HTML support.';
        } else {
            $this->mail->Body = $message;
        }
        if($atachments != null) {
            foreach ($atachments as $atachment) {
                $this->mail->addAttachment($atachment);
            }
        }
        return $this;
    }

    public function send(): bool {
        if (!$this->mail->send()) {
            Helpers::debug($this->mail->ErrorInfo);
        } else {
            return true;
        }
    }

    public function setFrom(string $from): Mailer
    {
        $this->from = $from;
        return $this;
    }

    public function getFrom(): string {
        return $this->from;
    }

    public function setFromName(string $fromName): Mailer
    {
        $this->fromName = $fromName;
        return $this;
    }

    public function getFromName(): string {
        return $this->fromName;
    }

}
