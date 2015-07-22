<?php

namespace Signable\Example;
use Signable;

echo '<h1>Example Responses for each API method</h1>';

require('../../vendor/autoload.php');
Signable\ApiClient::setApiKey( '0742b82b9085c3d1c4b5d545bec6cbea' );

echo '<h4>require("../../vendor/autoload.php")</h4>';

echo '<h4>Signable\ApiClient::setApiKey( "0742b82b9085c3d1c4b5d545bec6cbea" );</h4>';

echo '<h2>Webhooks</h2>';

echo '<h4>Signable\Webhooks::createNew("send-envelope", "www.new-webhook.com")</h4>';
try {
    $response = Signable\Webhooks::createNew('send-envelope', 'www.new-webhook.com');
    var_dump($response);
    $webhook_id = $response->webhook_id;
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Webhooks::getSingle(' . $webhook_id . ')</h4>';
try {
    $response = Signable\Webhooks::getSingle($webhook_id);
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Webhooks::getMultiple()</h4>';
try {
    $response = Signable\Webhooks::getMultiple();
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Webhooks::update(' . $webhook_id . ', "signed-envelope", "www.updated-webhook.com")</h4>';
try {
    $response = Signable\Webhooks::update($webhook_id, 'signed-envelope', 'www.updated-webhook.com');
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Webhooks::delete(' . $webhook_id . ')</h4>';
try {
    $response = Signable\Webhooks::delete($webhook_id);
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}