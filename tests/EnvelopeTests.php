<?php

namespace Signable;

class EnvelopeTests extends TestCase {

    private $envelope;

    /**
     * Setup anything required for the envelope tests - ran before each test
     */
    protected function setUp() {

        $mergeFields         = array();
        $mergeField          = new MergeField( 20000, 'Test merge' );
        $mergeFields[]       = $mergeField;

        $envelopeDocuments   = array();
        $envelopeDocument    = new DocumentWithTemplate( 'New Document', '51209051e0ae7515b6e27b37b85f99b9', $mergeFields );
        $envelopeDocuments[] = $envelopeDocument;

        $envelopeParties     = array();
        $envelopeParty       = new Party( 'Signatory', 'new@party.com', 940399, 'New message' );
        $envelopeParties[]   = $envelopeParty;

        $this->envelope      = Envelopes::createNewWithTemplate( "New Envelope", $envelopeDocuments, $envelopeParties );
    }

    /**
     * Remove anything required for the envelope tests - ran after each test
     */
    protected function tearDown() {

        $envelopes = Envelopes::getMultiple( 0, 100 );
        foreach ( $envelopes->envelopes as $envelope ) {
            try {
                Envelopes::expire( $envelope->envelope_fingerprint );
            } catch( \Exception $e ) {

            }
        }
    }

    /**
     * Test the expected exception is thrown if parameters are missing
     */
    public function testMissingParameters() {

        $message = 'The title is missing. To be able to create a new envelope, you must provide a title.';
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( '', array(), array() ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( '', array(), array() ), $message );

        $envelopeDocumentsWith      = array();
        $envelopeDocument           = new DocumentWithTemplate( 'New Document', 'e6b937d6cb0df6e6ab60021928b06097' );
        $envelopeDocumentsWith[]    = $envelopeDocument;
        $envelopeDocumentsWithout   = array();
        $envelopeDocument           = new DocumentWithoutTemplate( 'New Document', 'https://www.swiftview.com/tech/letterlegal5.doc' );
        $envelopeDocumentsWithout[] = $envelopeDocument;

        $message = 'The party array is blank or empty';
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', $envelopeDocumentsWith, array() ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', $envelopeDocumentsWithout, array() ), $message );

        $envelopeParties   = array();
        $envelopeParty     = new Party( 'Signatory', 'new@party.com', 'signer1', 'New message', 'no' );
        $envelopeParties[] = $envelopeParty;

        $message = 'The document array is blank or empty';
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', array(), $envelopeParties ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', array(), $envelopeParties ), $message );

        $message = 'To retrieve a single envelope, please pass in an envelope fingerprint.';
        $this->runTryCatchForMethod( 'getSingle', array( null ), $message );

        $message = 'The envelope does not exist. Have you used the correct envelope fingerprint?';
        $this->runTryCatchForMethod( 'sendReminder', array( null ), $message );
        $this->runTryCatchForMethod( 'cancel', array( null ), $message );
        $this->runTryCatchForMethod( 'expire', array( null ), $message );
    }

    /**
     * Test the expected exception is thrown if incorrect parameter is used
     */
    public function testInvalidParam() {

        $message = 'The documents array is not an array.';
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', '', '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', '', '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', new \stdClass(), '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', new \stdClass(), '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', 1234, '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', 1234, '' ), $message );

        $message = 'The title is missing. To be able to create a new envelope, you must provide a title.';
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( array(), '', '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( new \stdClass(), '', '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( array(), '', '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( new \stdClass(), '', '' ), $message );

        $message = 'The party array is not an array.';
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', array(), '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', array(), '' ), $message );
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', array(), new \stdClass() ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', array(), new \stdClass() ), $message );
        $this->runTryCatchForMethod( 'createNewWithTemplate', array( 'title', array(), 1234 ), $message );
        $this->runTryCatchForMethod( 'createNewWithoutTemplate', array( 'title', array(), 1234 ), $message );

        $message = 'Array to string conversion';
        $this->runTryCatchForMethod( 'getSingle', array( array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( array(), array() ), $message );
        $this->runTryCatchForMethod( 'sendReminder', array( array() ), $message );
        $this->runTryCatchForMethod( 'cancel', array( array() ), $message );
        $this->runTryCatchForMethod( 'expire', array( array() ), $message );

        $message = 'Object of class stdClass could not be converted to string';
        $this->runTryCatchForMethod( 'getSingle', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( (object) array(), (object) array() ), $message );
        $this->runTryCatchForMethod( 'sendReminder', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'cancel', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'expire', array( (object) array() ), $message );
    }

    /**
     * Test the expected exception is thrown if envelope doesn't exist
     */
    public function testWrongID() {

        $message = 'The envelope does not exist. Have you used the correct envelope fingerprint?';
        $this->runTryCatchForMethod( 'getSingle', array( '1' ), $message );
        $this->runTryCatchForMethod( 'sendReminder', array( '1' ), $message );
        $this->runTryCatchForMethod( 'cancel', array( '1' ), $message );
        $this->runTryCatchForMethod( 'expire', array( '1' ), $message );
    }

    /**
     * Test responses are as expected when successful calls are made
     */
    public function testGoodResponses() {

        $actual   = Envelopes::getSingle( $this->envelope->envelope_fingerprint );
        $expected = $this->managedSuccessfulGetSingleResponse( $actual->envelope_fingerprint, $actual->envelope_created, $actual->envelope_sent, $actual->envelope_parties, $actual->envelope_documents );
        $this->assertEquals( $expected, $actual );

        $multiple = Envelopes::getMultiple();
        $this->assertEquals( 10, count( $multiple->envelopes ) );

        $mergeFields         = array();
        $mergeField          = new MergeField( 20000, 'Test merge' );
        $mergeFields[]       = $mergeField;
        $envelopeDocuments   = array();
        $envelopeDocument    = new DocumentWithTemplate( 'New Document', '51209051e0ae7515b6e27b37b85f99b9', $mergeFields );
        $envelopeDocuments[] = $envelopeDocument;
        $envelopeParties     = array();
        $envelopeParty       = new Party( 'Signatory', 'new@party.com', 940399, 'New message', 'yes' );
        $envelopeParties[]   = $envelopeParty;

        $actual   = Envelopes::createNewWithTemplate( 'Test Envelope', $envelopeDocuments, $envelopeParties, 5, true, 'redirect_url' );
        $expected = $this->managedSuccessfulCreateEnvelopeResponse( $actual->envelope_fingerprint, $actual->envelope_queued );
        $this->assertEquals( $expected, $actual );

        $envelopeDocuments   = array();
        $envelopeDocument    = new DocumentWithoutTemplate( 'New Document', 'https://www.swiftview.com/tech/letterlegal5.doc' );
        $envelopeDocuments[] = $envelopeDocument;
        $envelopeParties     = array();
        $envelopeParty       = new Party( 'Signatory', 'new@party.com', 'signer1', 'New message', 'no' );
        $envelopeParties[]   = $envelopeParty;

        $actual   = Envelopes::createNewWithoutTemplate( 'Test Envelope', $envelopeDocuments, $envelopeParties, 5, true, 'redirect_url' );
        $expected = $this->managedSuccessfulCreateEnvelopeResponse( $actual->envelope_fingerprint, $actual->envelope_queued );
        $this->assertEquals( $expected, $actual );

        $actual   = Envelopes::sendReminder( $this->envelope->envelope_fingerprint );
        $expected = $this->managedSuccessfulReminderEnvelopeResponse(  $this->envelope->envelope_fingerprint );
        $this->assertEquals( $expected, $actual );

        $actual   = Envelopes::cancel( $actual->envelope_fingerprint );
        $expected = $this->managedSuccessfulCancelEnvelopeResponse( $actual->envelope_fingerprint );
        $this->assertEquals( $expected, $actual );

//        CANNOT CURRENTLY EXPIRE ENVELOPES - HAVE TO BE SIGNED/COMPLETED FIRST??
//        $actual   = Envelopes::expire( $actual->envelope_fingerprint );
//        $expected = $this->managedSuccessfulExpireEnvelopeResponse( $actual->envelope_fingerprint );
//        $this->assertEquals( $expected, $actual );
    }

    /**
     * Mock expected successful response when an envelope is created
     *
     * @param  int    $fingerprint envelope fingerprint
     * @param  string $queued      time when envelope was created
     * @return object              mock response mimicking API call
     */
    private function managedSuccessfulCreateEnvelopeResponse( $fingerprint, $queued ) {

        return (object) array(
            'http'                      => 202,
            'message'                   => 'Your envelope with title Test Envelope will be processed and sent out.',
            'href'                      => 'https://api.signable.co.uk/v1/envelopes/' . $fingerprint,
            'envelope_title'            => 'Test Envelope',
            'envelope_fingerprint'      => $fingerprint,
            'envelope_password_protect' => false,
            'envelope_redirect_url'     => 'redirect_url',
            'envelope_queued'           => $queued,
        );
    }

    /**
     * Mock expected successful response when an envelope is retrieved
     *
     * @param  int    $fingerprint envelope fingerprint
     * @param  string $created     time when envelope was created
     * @param  string $sent        time when envelope was sent
     * @param  array  $parties     parties attached to envelope
     * @return object              mock response mimicking API call
     */
    private function managedSuccessfulGetSingleResponse( $fingerprint, $created, $sent, $parties, $documents ) {

        return (object) array(
            'http'                  => 200,
            'envelope_fingerprint'  => $fingerprint,
            'envelope_title'        => 'New Envelope',
            'envelope_status'       => 'sent',
            'envelope_redirect_url' => null,
            'envelope_created'      => $created,
            'envelope_sent'         => $sent,
            'envelope_processed'    => null,
            'envelope_parties'      => $parties,
            'envelope_documents'    => $documents,
        );
    }

    /**
     * Mock expected successful response when an envelope reminder is sent
     *
     * @param  int    $fingerprint envelope fingerprint
     * @return object              mock response mimicking API call
     */
    private function managedSuccessfulReminderEnvelopeResponse( $fingerprint ) {

        return (object) array(
            'http'                 => 200,
            'message'              => 'The next signing party for this envelope has been reminded.',
            'envelope_fingerprint' => $fingerprint,
            'envelope_title'       => 'New Envelope',
        );
    }

    /**
     * Mock expected successful response when an envelope is cancelled
     *
     * @param  int    $fingerprint envelope fingerprint
     * @return object              mock response mimicking API call
     */
    private function managedSuccessfulCancelEnvelopeResponse( $fingerprint ) {

        return (object)array(
            'http'                 => 200,
            'message'              => 'The envelope has been cancelled',
            'envelope_fingerprint' => $fingerprint,
            'envelope_title'       => 'New Envelope',
            'envelope_status'      => 'cancelled',
        );
    }

    /**
     * Mock expected successful response when an envelope is expired
     *
     * @param  int    $fingerprint envelope fingerprint
     * @return object              mock response mimicking API call
     */
    private function managedSuccessfulExpireEnvelopeResponse( $fingerprint ) {

        return (object)array(
            'http'                 => 200,
            'message'              => 'The envelope has been expired',
            'envelope_fingerprint' => $fingerprint,
            'envelope_title'       => 'New Envelope',
        );
    }

    /**
     * Run a try and catch on the provided parameters to test the API response
     *
     * @param string $method  The name of the method we want to test
     * @param array  $params  An array of the parameters required for the method
     * @param string $message The exception message we expect to see
     */
    private function runTryCatchForMethod( $method, $params, $message ) {

        switch ( $method ) {

            case 'createNewWithTemplate' :
                try {
                    Envelopes::createNewWithTemplate( $params[0], $params[1], $params[2] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'createNewWithoutTemplate' :
                try {
                    Envelopes::createNewWithoutTemplate( $params[0], $params[1], $params[2] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'getSingle' :
                try {
                    Envelopes::getSingle( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'getMultiple' :
                try {
                    Envelopes::getMultiple();
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'sendReminder' :
                try {
                    Envelopes::sendReminder( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'cancel' :
                try {
                    Envelopes::cancel( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );

                }
                break;

            case 'expire' :
                try {
                    Envelopes::expire( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );

                }
                break;
        }
    }
}