<?php
namespace App;

use App\Helpers\Misc;
use PHPMailer\PHPMailer\PHPMailer;

class Mail {
    private PHPMailer $client;

    const SUBJECT = 'Verificación WikiUMA-ng';
    const BODY_PLAIN = <<<EOD
    ¡Bienvenido a WikiUMA-ng!
    Verifica tu cuenta con este enlace: %s
    Si tienes problemas para verificar tu cuenta puedes contactar con la administración aquí: %s
    Este es un mensaje automático, por favor no respondas a este correo.
    EOD;

    const BODY_HTML = <<<EOD
    <p>Bienvenido a WikiUMA-ng!</p>
    <p>Verifica tu cuenta con este <a href="%s">enlace</a><p>
    <p>
        Si tienes problemas para verificar tu cuenta puedes contactar con la administración <a href="%s">aquí</a>
    </p>
    <p>Este es un mensaje automático, por favor <b>no respondas a este correo</b></p>
    EOD;

    function __construct() {
        $host = Misc::env('MAIL_HOST', '');
        $port = Misc::env('MAIL_PORT', 465);
        $username = Misc::env('MAIL_USERNAME', '');
        $password = Misc::env('MAIL_PASSWORD', '');
        $encryption = Misc::env('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_SMTPS);

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = $encryption;
        $mail->Port = $port;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $this->client = $mail;
    }


    public function sendCode(string $destionation, string $code): bool {
        $this->client->setFrom($this->client->Username, 'WikiUMA');
        $this->client->addAddress($destionation);
        $this->client->Subject = self::SUBJECT;

        $link = Misc::url('/verify', [
            'code' => $code
        ]);

        $this->client->Body = $this->__html($link);
        $this->client->AltBody = $this->__plain($link);
        $success = $this->client->send();
        return $success;
    }

    private function __plain(string $link): string {
        $contact = Misc::contact();
        $plain = sprintf(self::BODY_PLAIN, $link, $contact);
        return $plain;
    }

    private function __html(string $link): string {
        $contact = Misc::contact();
        $html = sprintf(self::BODY_HTML, $link, $contact);
        return $html;
    }
}
