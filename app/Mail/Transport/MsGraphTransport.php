<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Swift_Events_EventListener;
use Swift_Mime_SimpleMessage;
use Swift_Transport;

class MsGraphTransport implements Swift_Transport
{
    private string $tenantId;
    private string $clientId;
    private string $clientSecret;
    private string $fromAddress;

    public function __construct()
    {
        $this->tenantId     = config('msgraph.tenant_id');
        $this->clientId     = config('msgraph.client_id');
        $this->clientSecret = config('msgraph.client_secret');
        $this->fromAddress  = config('mail.from.address');
    }

    public function isStarted(): bool { return true; }
    public function start(): void {}
    public function stop(): void {}
    public function ping(): bool { return true; }
    public function registerPlugin(Swift_Events_EventListener $plugin): void {}

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null): int
    {
        $token = $this->getAccessToken();

        $toRecipients = [];
        foreach (array_keys($message->getTo() ?? []) as $address) {
            $toRecipients[] = ['emailAddress' => ['address' => $address]];
        }

        $ccRecipients = [];
        foreach (array_keys($message->getCc() ?? []) as $address) {
            $ccRecipients[] = ['emailAddress' => ['address' => $address]];
        }

        $htmlBody = null;
        $attachments = [];
        foreach ($message->getChildren() as $child) {
            if ($child instanceof \Swift_MimePart && str_contains($child->getContentType(), 'html')) {
                $htmlBody = $child->getBody();
            } elseif ($child instanceof \Swift_Attachment) {
                $attachments[] = [
                    '@odata.type'  => '#microsoft.graph.fileAttachment',
                    'name'         => $child->getFilename() ?? 'attachment',
                    'contentType'  => $child->getContentType(),
                    'contentBytes' => base64_encode($child->getBody()),
                ];
            }
        }

        if ($htmlBody === null) {
            $htmlBody    = $message->getBody();
            $contentType = str_contains($message->getContentType(), 'html') ? 'HTML' : 'Text';
        } else {
            $contentType = 'HTML';
        }

        $payload = [
            'message' => [
                'subject'      => $message->getSubject(),
                'body'         => ['contentType' => $contentType, 'content' => $htmlBody],
                'toRecipients' => $toRecipients,
            ],
            'saveToSentItems' => true,
        ];

        if (!empty($ccRecipients)) {
            $payload['message']['ccRecipients'] = $ccRecipients;
        }

        if (!empty($attachments)) {
            $payload['message']['attachments'] = $attachments;
        }

        Http::withToken($token)
            ->post("https://graph.microsoft.com/v1.0/users/{$this->fromAddress}/sendMail", $payload)
            ->throw();

        return count($toRecipients) + count($ccRecipients);
    }

    private function getAccessToken(): string
    {
        $response = Http::asForm()->post(
            "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token",
            [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope'         => 'https://graph.microsoft.com/.default',
            ]
        )->throw()->json();

        return $response['access_token'];
    }
}
