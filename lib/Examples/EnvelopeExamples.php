<?php

namespace Signable\Example;
use Signable;

echo '<h1>Example Responses for each API method</h1>';

require('../../vendor/autoload.php');
Signable\ApiClient::setApiKey( '0742b82b9085c3d1c4b5d545bec6cbea' );

echo '<h4>require("../../vendor/autoload.php")</h4>';
echo '<h4>Signable\ApiClient::setApiKey( "0742b82b9085c3d1c4b5d545bec6cbea" );</h4>';
echo '<h2>Envelopes</h2>';
echo '<h4>Signable\Envelopes::createNewWithTemplate( "New Envelope", $envelopeDocuments, $envelopeParties )</h4>';

$mergeFields         = array();
$mergeField          = new Signable\MergeField( 20000, 'Test merge' );
$mergeFields[]       = $mergeField;

$envelopeDocuments   = array();
$envelopeDocument    = new Signable\DocumentWithoutTemplate( 'New Document', '51209051e0ae7515b6e27b37b85f99b9', $mergeFields );
$envelopeDocuments[] = $envelopeDocument;

$envelopeParties     = array();
$envelopeParty       = new Signable\Party( 'Signatory', 'new@party.com', 940399, 'New message' );
$envelopeParties[]   = $envelopeParty;

try {
    $response = Signable\Envelopes::createNewWithTemplate( "New Envelope", $envelopeDocuments, $envelopeParties );
    var_dump( $response );
    $envelopeFingerprint = $response->envelope_fingerprint;
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}

echo '<h4>Signable\Envelopes::createNewWithoutTemplate( "New Envelope", $envelopeDocuments, $envelopeParties )</h4>';

$mergeFields         = array();
$mergeField          = new Signable\MergeField( 20000, 'Test merge' );
$mergeFields[]       = $mergeField;

$envelopeDocuments   = array();
$envelopeDocument    = new Signable\DocumentWithoutTemplate( 'New Document', 'https://www.swiftview.com/tech/letterlegal5.doc' );
$envelopeDocuments[] = $envelopeDocument;

$envelopeParties     = array();
$envelopeParty       = new Signable\Party( 'Signatory', 'signatory@test.com', 'signer1', 'New message', 'no' );
$envelopeParties[]   = $envelopeParty;


$user = Signable\Users::createNew( 'John Smith', 'john@smith.com' );

try {
    $response = Signable\Envelopes::createNewWithoutTemplate( "New Envelope", $envelopeDocuments, $envelopeParties, $user->user_id );
    var_dump( $response );
    $envelopeFingerprintTwo = $response->envelope_fingerprint;
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}

Signable\Users::delete( $user->user_id );

echo '<h4>Signable\Envelopes::getSingle(' . $envelopeFingerprint . ')</h4>';
try {
    $response = Signable\Envelopes::getSingle( $envelopeFingerprint );
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}

echo '<h4>Signable\Envelopes::getMultiple()</h4>';
try {
    $response = Signable\Envelopes::getMultiple();
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}

echo '<h4>Signable\Envelopes::sendReminder(' . $envelopeFingerprint . ')</h4>';
try {
    $response = Signable\Envelopes::sendReminder( $envelopeFingerprint );
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}

echo '<h4>Signable\Envelopes::cancel(' . $envelopeFingerprintTwo . ')</h4>';
try {
    $response = Signable\Envelopes::cancel( $envelopeFingerprintTwo );
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}

echo '<h4>Signable\Envelopes::expire(' . $envelopeFingerprintTwo . ')</h4>';
try {
    $response = Signable\Envelopes::expire( $envelopeFingerprintTwo );
    var_dump( $response );
} catch ( Signable\Error\ApiError $e ) {
    var_dump( $e );
}