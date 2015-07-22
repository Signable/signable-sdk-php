<?php

namespace Signable\Example;
use Signable;

echo '<h1>Example Responses for each API method</h1>';

require('../../vendor/autoload.php');
Signable\ApiClient::setApiKey( '0742b82b9085c3d1c4b5d545bec6cbea' );

echo '<h4>require("../../vendor/autoload.php")</h4>';

echo '<h4>Signable\ApiClient::setApiKey( "0742b82b9085c3d1c4b5d545bec6cbea" );</h4>';

echo '<h2>Teams</h2>';

echo '<h4>Signable\Teams::createNew( "New Team" )</h4>';
try {
    $response = Signable\Teams::createNew( 'New Team' );
    $team_id = $response->team_id;
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Teams::getSingle(' . $team_id . ')</h4>';
try {
    $response = Signable\Teams::getSingle($team_id);
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Teams::getMultiple()</h4>';
try {
    $response = Signable\Teams::getMultiple();
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Teams::update(' . $team_id . ', "Updated Team")</h4>';
try {
    $response = Signable\Teams::update($team_id, 'Updated Team');
    var_dump($response);
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}
echo '<h4>Signable\Teams::delete(' . $team_id . ')</h4>';
try {
    $response = Signable\Teams::delete( $team_id );
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}