<?php

namespace Signable\Examples;
use Signable;

echo '<h1>Example Responses for each API method</h1>';

require('../../vendor/autoload.php');
Signable\ApiClient::setApiKey( '0742b82b9085c3d1c4b5d545bec6cbea' );

echo '<h4>require("../../vendor/autoload.php")</h4>';

echo '<h4>Signable\ApiClient::setApiKey( "0742b82b9085c3d1c4b5d545bec6cbea" )</h4>';

echo '<h2>Contacts</h2>';
echo '<h4>Signable\Contacts::createNew( "New Contact", "new@contact.com" )</h4>';
try {
    $response = Signable\Contacts::createNew( 'New Contact', 'new@contact.com' );
    $contact_id = $response->contact_id;
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Contacts::getSingle(' . $contact_id . ')</h4>';
try {
    $response = Signable\Contacts::getSingle($contact_id);
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Contacts::getMultiple()</h4>';
try {
    $response = Signable\Contacts::getMultiple();
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Contacts::update(' . $contact_id . ', "Updated Contact", "updated@contact.com")</h4>';
try {
    $response = Signable\Contacts::update($contact_id, 'Updated Contact', 'updated@contact.com');
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Contacts::listEnvelopes(' . $contact_id . ')</h4>';
try {
    $response = Signable\Contacts::listEnvelopes($contact_id);
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Contacts::delete(' . $contact_id . ')</h4>';
try {
    $response = Signable\Contacts::delete($contact_id);
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}