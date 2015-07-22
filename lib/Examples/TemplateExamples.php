<?php

namespace Signable\Example;
use Signable;

echo '<h1>Example Responses for each API method</h1>';

require('../../vendor/autoload.php');
Signable\ApiClient::setApiKey( '0742b82b9085c3d1c4b5d545bec6cbea' );

echo '<h4>require("../../vendor/autoload.php")</h4>';

echo '<h4>Signable\ApiClient::setApiKey( "0742b82b9085c3d1c4b5d545bec6cbea" );</h4>';

echo '<h2>Templates</h2>';

echo '<h4>Signable\Templates::getSingle( "51209051e0ae7515b6e27b37b85f99b9" )</h4>';
try {
    $response = Signable\Templates::getSingle( '51209051e0ae7515b6e27b37b85f99b9' );
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Templates::getMultiple()</h4>';
try {
    $response = Signable\Templates::getMultiple();
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Templates::delete()</h4>';