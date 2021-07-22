<?php

namespace App\Services\Mailer;

require './Core/lib/PHPMailer/src/Exception.php';
require './Core/lib/PHPMailer/src/PHPMailer.php';

use App\Core\Helpers;
use App\Repository\WebsiteConfigurationRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    /**
     * @var PHPMailer
     */
    private $mail;

    /**
     * @var string
     */
    private $from = 'no-reply@framework.fr';

    /**
     * @var string
     */
    private $fromName = '';

    /**
     * Mailer constructor.
     * @param string $language
     */
    public function __construct($language = 'fr') {
        $this->mail = new PHPMailer(true); //init
        $this->mail->setLanguage($language, '../../Core/lib/PHPMailer/language/'); // lang
        $this->mail->SMTPDebug = (ENV == 'dev' ? 1 : 0);
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = WebsiteConfigurationRepository::getSMTPGmailAccount();
        $this->mail->Password   = WebsiteConfigurationRepository::getSMTPGmailPassword();
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port       = 465;
    }

    /**
     * @param string $sendTo
     * @param string $subject
     * @param string|null $message
     * @param string|null $replyTo
     * @param bool $isHTML
     * @param string ...$atachments
     * @return $this
     * @throws Exception
     * prepare email to be send
     */
    public function prepare(string $sendTo, string $subject, string $message = null, string $replyTo = null, bool $isHTML = true, string ...$atachments): Mailer {
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

    /**
     * @return bool
     * @throws Exception
     * send email
     */
    public function send(): bool {
        if (!$this->mail->send()) {
            Helpers::error($this->mail->ErrorInfo);
        } else {
            return true;
        }
        return false;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function setFrom(string $from): Mailer
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string {
        return $this->from;
    }

    /**
     * @param string $fromName
     * @return $this
     */
    public function setFromName(string $fromName): Mailer
    {
        $this->fromName = $fromName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromName(): string {
        return $this->fromName;
    }

}
