<?php

namespace Signable\Example;
use Signable;

echo '<h1>Example Responses for each API method</h1>';

require('../../vendor/autoload.php');
Signable\ApiClient::setApiKey( '0742b82b9085c3d1c4b5d545bec6cbea' );

echo '<h4>require("../../vendor/autoload.php")</h4>';

echo '<h4>Signable\ApiClient::setApiKey( "0742b82b9085c3d1c4b5d545bec6cbea" );</h4>';

echo '<h2>Users</h2>';

echo '<h4>Signable\Users::createNew("John Smith", "john@smith.com")</h4>';
try {
    $response = Signable\Users::createNew('John Smith', 'john@smith.com');
    var_dump($response);
    $user_id = $response->user_id;
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Users::getSingle(' . $user_id . ')</h4>';
try {
    $response = Signable\Users::getSingle( $user_id );
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Users::getMultiple()</h4>';
try {
    $response = Signable\Users::getMultiple();
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Users::update(' . $user_id . ', "John Was Smith", "john@was_smith.com")</h4>';
try {
    $response = Signable\Users::update($user_id, 'John Was Smith', 'john@was_smith.com');
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Users::delete(' . $user_id . ')</h4>';
try {
    $response = Signable\Users::delete($user_id);
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}