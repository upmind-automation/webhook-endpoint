<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Upmind\Webhooks\Auth\SignatureAuth;
use Upmind\Webhooks\Exceptions\WebhookException;
use Upmind\Webhooks\WebhookFactory;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $factory = new WebhookFactory(config('app.upmind_webhook_secret'));

        // get the payload and signature from the incoming request
        $payload = $request->getContent();
        $signature = $request->header(SignatureAuth::HEADER) ?: null;

        try {
            // create the webhook instance and authenticate it
            $webhook = $factory->fromString($payload, $signature);
            $webhook->assertValidAuth();
        } catch (WebhookException $e) {
            return response($e->getMessage(), $e->getHttpCode());
        }

        // handle webhook events in a queued job to help avoid incoming webhook timeouts
        dispatch(new HandleWebhookEvents($webhook->getEvents()));

        // return a 200 response to acknowledge receipt of the webhook
        return response('Webhook received', 200);
    }
}
