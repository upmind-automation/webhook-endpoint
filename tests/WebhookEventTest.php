<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Tests;

use Upmind\Webhooks\WebhookFactory;

/**
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps,Generic.Files.LineLength.TooLong
 */
class WebhookEventTest extends TestCase
{
    /** @test */
    public function serializes_to_json()
    {
        $factory = new WebhookFactory();
        $webhook = $factory->fromString($this->getValidV1Payload());

        $eventAsJson = '{"id":"37506382-d5e9-0313-95a5-124867794de5","datetime":"2023-08-07 20:59:37","category_code":"client","hook_code":"user_created_unverified_client_hook","hook_log_id":"d9465824-5730-9190-97eb-d128ed6e3d70","object_type":"client","object":{"id":"506382d5-e903-1365-6d6a-5124867794de","import_id":null,"staged_import":false,"external_id":null,"support_pin":null,"support_pin_expiry_datetime":null,"firstname":"Harry","lastname":"L","has_login":true,"email":"harry+customer@upmind.com","location_source":null,"location_town":null,"location_country_code":null,"location_ip":null,"user_id":"e5750263-4647-9ed1-26a2-1053288d79e9","upmind_org_user_id":null,"created_at":"2023-08-07 20:59:34","updated_at":"2023-08-07 20:59:34","reseller_account_id":null,"interface_language_id":"869d9865-7e5d-4021-e6c9-1837690e4323","document_language_id":"869d9865-7e5d-4021-e6c9-1837690e4323","deleted_at":null,"verified":false,"apply_credit":0,"credit":null,"consolidate_invoice":0,"consolidation_day":null,"bf_id":"none","ip_address":null,"enabled_2fa":false,"provider_2fa_id":null,"org_id":"e5750263-4647-9ed1-26a2-1053288d79e9","picture":0,"brand_id":"905d39e2-d364-0717-d0a4-12e598467803","fraud_policy":1,"fraud_status":1,"last_login":null,"failed_login_attempts":0,"is_guest":false,"notifications_disabled":false,"meta":null,"order_template_code":null,"invoice_consolidation_enabled":2,"invoice_consolidation_base_rule":null,"invoice_consolidation_base_rule_date_of_month_day":null,"invoice_consolidation_base_rule_day_of_week":null,"block_new_tickets_from_email":false,"interface_language_code":"en","document_language_code":"en","fullname":"Harry L","public_name":"Harry L.","secret_2fa_exists":false,"image_url":null,"topup_enabled":null,"upmind_org_user":null,"upmind_package_limits":[],"first_name":"Harry","last_name":"L","full_name":"Harry L","login_email":"harry+customer@upmind.com","notification_email":"harry+customer@upmind.com","twofa_enabled":false,"twofa_provider":null,"reg_hash":"3d43389efc170ff1dbe0b064a4ba8407ef04dfd9","reg_hash_expiry":"","avatar_src":null,"interface_language":"en","document_language":"en","has_password":false,"default_payment_details":null,"default_address":null,"default_email":{"id":"50263464-79ed-1278-760a-21053288d79e","client_id":"506382d5-e903-1365-6d6a-5124867794de","email":"harry+customer@upmind.com","reg_hash":"e21e8c4cfb95232c188940a7eb0347b198ddfeb2","reg_hash_expiry":"2024-08-07 20:59:34","type":"Personal","default":true,"verified":false,"created_at":"2023-08-07 20:59:34","updated_at":"2023-08-07 20:59:34"},"default_phone":null,"custom_field_values":[]},"actor_type":"user","actor":null,"brand":{"id":"905d39e2-d364-0717-d0a4-12e598467803","name":"ExampleHost","code":"abfya8btxnlb","prefix":"abfya8btxnlb","customer_portal_domain":"abfya8btxnlb.upmind.local","staff_portal_domain":"abfya8btxnlb.upmind.local","company_name":"ExampleHost","company_address":"123 Fake Street,\nFakeville,\nFA1 7KE,\nGB","company_phone":"01234 567890","company_email":"harry@upmind.com","country":"GB","language":"en","currency":"GBP","tax_type":0,"vat_number":"","payment_days_term":0,"create_invoice_term":0,"style":null,"logo_src":null,"created_at":"2023-08-07 20:58:21","updated_at":"2023-08-07 20:58:21","organisation":{"id":"e5750263-4647-9ed1-26a2-1053288d79e9","name":"ExampleHost","code":"abfya8btxnlb","verified":true,"completed":false,"status":null,"staff_portal_domain":"abfya8btxnlb.upmind.local","reg_hash":null,"reg_hash_expiry":null}}}';

        $this->assertEquals($eventAsJson, json_encode($webhook->getEvents()[0]));
    }
}
