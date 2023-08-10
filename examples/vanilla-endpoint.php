<?php

use Upmind\Webhooks\Exceptions\WebhookException;
use Upmind\Webhooks\WebhookFactory;

$endpointSecret = 'xxxxxxxxxx';
$factory = new WebhookFactory($endpointSecret);

try {
    // get the webhook instance and authenticate it
    $webhook = $factory->create();
    $webhook->assertValidAuth();
} catch (WebhookException $e) {
    http_response_code($e->getHttpCode());
    exit($e->getMessage());
}

// Do something with the webhook event(s)
foreach ($webhook->getEvents() as $event) {
    $eventId = $event->getId();
    $objectData = $event->getObjectData();

    switch ($event->getHookCode()) {
        case 'invoice_payment_received_hook':
            // Do something with the invoice payment received event
            // $client = $objectData['client'];
            // $transactionId = $objectData['transaction_id'];
            // $invoiceNumber = $objectData['invoice']['number'];
            break;
        case 'contract_product_activated_hook':
            // Do something with the contract product activated event ...
            // $provisionFieldValues = $objectData['provision_field_values'];
            break;
            // case '...':
            // break;
    }
}

// return a 200 response to acknowledge receipt of the webhook
http_response_code(200);
exit('Webhook received');
