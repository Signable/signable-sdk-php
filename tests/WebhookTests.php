<?php

namespace Signable;

class WebhookTests extends TestCase {

    private $webhook;

    /**
     * Setup anything required for the webhook tests - ran before each test
     */
    protected function setUp() {

        $this->webhook = Webhooks::createNew( 'send-envelope', 'www.test-webhook.com' );
    }

    /**
     * Remove anything required for the webhook tests - ran after each test
     */
    protected function tearDown() {

        $webhooks = Webhooks::getMultiple();
        foreach ( $webhooks->webhooks as $webhook ) {
            Webhooks::delete( $webhook->webhook_id );
        }
    }

    /**
     * Test the expected exception is thrown if parameters are missing
     */
    public function testMissingParameters() {

        $message = 'The webhook type is missing.';
        $this->runTryCatchForMethod( 'createNew', array( '', '' ), $message );

        $message = 'The webhook URL is missing.';
        $this->runTryCatchForMethod( 'createNew', array( 'webhook', '' ), $message );

        $message = 'To retrieve a single webhook, please pass in a webhook ID.';
        $this->runTryCatchForMethod( 'getSingle', array( null ), $message );

        $message = 'To delete a webhook please pass in a webhook ID.';
        $this->runTryCatchForMethod( 'delete', array( '' ), $message );

        $message = 'To update a webhook please pass in a webhook ID';
        $this->runTryCatchForMethod( 'update', array( '', '', '' ), $message );
    }

    /**
     * Test the expected exception is thrown if incorrect parameter is used
     */
    public function testInvalidParam() {

        $message = 'Array to string conversion';
        $this->runTryCatchForMethod( 'getSingle', array( array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( array(), array() ), $message );
        $this->runTryCatchForMethod( 'delete', array( array() ), $message );
        $this->runTryCatchForMethod( 'update', array( array(), array(), array() ), $message );

        $message = 'Object of class stdClass could not be converted to string';
        $this->runTryCatchForMethod( 'getSingle', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( (object) array(), (object) array() ), $message );
        $this->runTryCatchForMethod( 'delete', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'update', array( (object) array(), (object) array(), (object) array() ), $message );
    }

    /**
     * Test the expected exception is thrown if webhook doesn't exist
     */
    public function testWrongID() {

        $message = 'No webhooks found.';
        $this->runTryCatchForMethod( 'getSingle', array( '1' ), $message );

        $message = 'The webhook does not exist. Have you used the correct webhook ID?';
        $this->runTryCatchForMethod( 'update', array( '1', 'send-envelope', 'url' ), $message );
        $this->runTryCatchForMethod( 'delete', array( '1' ), $message );
    }

    /**
     * Test responses are as expected when a successful calls are made
     */
    public function testGoodResponses() {

        $actual   = Webhooks::getSingle( $this->webhook->webhook_id );
        $expected = $this->managedSuccessfulGetSingleResponse( $this->webhook->webhook_id, $this->webhook->webhook_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Webhooks::getMultiple();
        $expected = $this->managedSuccessfulGetMultipleResponse( $this->webhook->webhook_id, $this->webhook->webhook_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Webhooks::createNew( 'send-envelope', 'www.test-webhook.com' );
        $expected = $this->managedSuccessfulCreateWebhookResponse( $actual->webhook_id, $actual->webhook_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Webhooks::update( $actual->webhook_id, 'signed-envelope', 'www.updated-webhook.com' );
        $expected = $this->managedSuccessfulUpdateWebhookResponse( $actual->webhook_id, $actual->webhook_updated );
        $this->assertEquals( $expected, $actual );

        $actual   = Webhooks::delete( $actual->webhook_id );
        $expected = $this->managedSuccessfulDeleteWebhookResponse( $actual->webhook_id );
        $this->assertEquals( $expected, $actual );
    }

    /**
     * Mock expected successful response when a webhook is created
     *
     * @param  int    $id      webhook id
     * @param  string $created time when webhook was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulCreateWebhookResponse( $id, $created ) {

        return (object)array(
            'http'            => 200,
            'message'         => 'The webhook (www.test-webhook.com) has been created',
            'href'            => 'https://api.signable.co.uk/v1/webhooks/' . $id,
            'webhook_id'      => $id,
            'webhook_url'     => 'www.test-webhook.com',
            'webhook_type'    => 'send-envelope',
            'webhook_created' => $created,
        );
    }

    /**
     * Mock expected successful response when a webhook is retrieved
     *
     * @param  int    $id webhook id
     * @param  string $created time when webhook was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetSingleResponse( $id, $created ) {

        return (object)array(
            'http'            => 200,
            'webhook_id'      => $id,
            'webhook_url'     => 'www.test-webhook.com',
            'webhook_type'    => 'send-envelope',
            'webhook_created' => $created,
            'webhook_updated' => null,
        );
    }

    /**
     * Mock expected successful response when a multiple webhooks are retrieved
     *
     * @param  int    $id      webhook id
     * @param  string $created time when webhook was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetMultipleResponse( $id, $created ) {

        $webhook = (object) array(
            'webhook_id'      => $id,
            'webhook_url'     => 'www.test-webhook.com',
            'webhook_type'    => 'send-envelope',
            'webhook_created' => $created,
            'webhook_updated' => null,
        );

        return (object) array(
            'http'        => 200,
            'offset'      => 0,
            'limit'       => 10,
            'total_webhooks' => '1',
            'webhooks'       => array (
                0 => $webhook,
            )
        );
    }

    /**
     * Mock expected successful response when a webhook is updated
     *
     * @param  int    $id      webhook id
     * @param  string $updated time when webhook was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulUpdateWebhookResponse( $id, $updated ) {

        return (object) array(
            'http'            => 200,
            'message'         => 'The webhook with ID ' . $id . ' has been updated',
            'href'            => 'https://api.signable.co.uk/v1/webhooks/' . $id,
            'webhook_id'      => $id,
            'webhook_url'     => 'www.updated-webhook.com',
            'webhook_type'    => 'signed-envelope',
            'webhook_updated' => $updated,
        );
    }

    /**
     * Mock expected successful response when a webhook is deleted
     *
     * @param  int    $id webhook id
     * @return object     mock response mimicking API call
     */
    private function managedSuccessfulDeleteWebhookResponse( $id ) {

        return (object)array(
            'http'         => 200,
            'message'      => 'The webhook (www.updated-webhook.com) has been removed from your account.',
            'webhook_id'   => $id,
            'webhook_url'  => 'www.updated-webhook.com',
            'webhook_type' => 'signed-envelope',
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

            case 'getSingle' :
                try {
                    Webhooks::getSingle( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'getMultiple' :
                try {
                    Webhooks::getMultiple( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'createNew' :
                try {
                    Webhooks::createNew( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'update' :
                try {
                    Webhooks::update( $params[0], $params[1], $params[2] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'delete' :
                try {
                    Webhooks::delete( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;
        }
    }
}