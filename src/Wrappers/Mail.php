<?php

namespace App\Wrappers;

use App\Models\Report;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private const string REPORT_NEW_SUBJECT = "Nuevo informe en WikiUMA";
    private PHPMailer $client;

    public function __construct()
    {
        $mail = Env::mail();
        $this->client = new PHPMailer();
        $this->client->CharSet = 'UTF-8';
        $this->client->isSMTP();
        $this->client->Host = $mail['host'];
        $this->client->Port = $mail['port'];

        if (!empty($mail['secure'])) {
            $this->client->SMTPSecure = $mail['secure'];
        }

        if (!empty($mail['password'])) {
            $this->client->SMTPAuth = true;
            $this->client->Username = $mail['username'];
            $this->client->Password = $mail['password'];
        }

        $this->client->setFrom($mail['username'], $mail['from']);
    }

    public function reportNew(Report $report, User $user): bool
    {
        $body = Render::plates('views/mails/report-new', [
            'report' => $report,
            'user' => $user,
        ]);

        return $this->__sendEmail($user->email, sprintf(self::REPORT_NEW_SUBJECT), $body);
    }

    private function __sendEmail(string $to, string $subject, string $body): bool
    {
        $this->client->addAddress($to);
        $this->client->Subject = sprintf($subject);

        $this->client->Body = $body;
        $ok = $this->client->send();

        // Cleanup
        $this->__cleanup();

        return $ok;
    }

    private function __cleanup(): void
    {
        $this->client->clearAddresses();
    }
}
