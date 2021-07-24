<section id="section-form-contact">
    <h1>Contactez-nous!</h1>
    <form method="POST" id="form-contact">
        <label for="email">E-mail: <input type="email" name="email" id="email" class="form_input"></label>
        <label for="subject">Subject: <input type="text" name="subject" id="subject" class="form_input"></label>
        <label for="message">Message: <textarea name="message" id="message" rows="8" cols="20" class="form_input"></textarea></label>
        <input type="submit" value="Envoyer" class="btn btn-primary">
    </form>
</section>
<?php
//if($_POST["email"] !== '' && $_POST["message"] !== ''){
//
//    $current_mail = new \App\Services\Mailer\Mailer();
//    $current_mail->setFrom($_POST["email"]);
//    $send_to = \App\Repository\WebsiteConfigurationRepository::getSMTPGmailAccount() ?? 'nilsmillot@gmail.com';
//    ($_POST["subject"] !== '') ? $subject = $_POST["subject"] : $subject = 'No subject';
//    $current_mail->prepare($send_to, $subject, $_POST["message"]);
//    $current_mail->send();

//}
?>

<style type="text/css">
    #section-form-contact{
        background-color: var(--midgrey-color);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    #form-contact{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    #form-contact > label {
        margin: 1rem 0;
    }
</style>
