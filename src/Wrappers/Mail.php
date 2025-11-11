<?php

namespace App\Wrappers;

use App\Models\Report;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private const string REPORT_STATUS_SUBJECT = "Resultado de su informe en WikiUMA";
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

    /**
     * Send report status to user
     */
    public function reportStatus(Report $report): bool
    {
        $this->client->addAddress($report->email);
        $this->client->Subject = sprintf(self::REPORT_STATUS_SUBJECT);

        $body = Render::plates('views/mails/report-status', [
            'report' => $report,
        ]);

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
