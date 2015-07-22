<?php

namespace Signable;

class ContactTests extends TestCase {

    private $contact;

    /**
     * Setup anything required for the contact tests - ran before each test
     */
    protected function setUp() {

        $this->contact = Contacts::createNew('Contact for tests', 'contact@for.tests.com');
    }

    /**
     * Remove anything required for the contact tests - ran after each test
     */
    protected function tearDown() {

        $contacts = Contacts::getMultiple();
        foreach ( $contacts->contacts as $contact ) {
            Contacts::delete( $contact->contact_id );
        }
    }

    /**
     * Test the expected exception is thrown if parameters are missing
     */
    public function testMissingParameters() {

        $message = 'The contact name is missing. To be able to create a new contact, you must provide a name.';
        $this->runTryCatchForMethod( 'createNew', array( '', '' ), $message );

        $message = 'The contact email is missing. To be able to create a new contact, you must provide an email address.';
        $this->runTryCatchForMethod( 'createNew', array( 'contact', '' ), $message );

        $message = 'To retrieve a single contact, please pass in a contact ID.';
        $this->runTryCatchForMethod( 'getSingle', array( null ), $message );

        $message = 'To delete a contact, please pass in a contact ID.';
        $this->runTryCatchForMethod( 'delete', array( '' ), $message );

        $message = 'To update a contact, please pass in a contact ID.';
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
        $this->runTryCatchForMethod( 'listEnvelopes', array( array() ), $message );

        $message = 'Object of class stdClass could not be converted to string';
        $this->runTryCatchForMethod( 'getSingle', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( (object) array(), (object) array() ), $message );
        $this->runTryCatchForMethod( 'delete', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'listEnvelopes', array( (object) array() ), $message );

        $message = 'Contact name and email must be a string to update a contact';
        $this->runTryCatchForMethod( 'update', array( array(), array(), array() ), $message );
        $this->runTryCatchForMethod( 'update', array( (object) array(), (object) array(), (object) array() ), $message );

        $message = 'Contact name and email must be a string to create a new contact';
        $this->runTryCatchForMethod( 'createNew', array( array( 'name', 'something' ), array( 'email' ) ), $message );
        $this->runTryCatchForMethod( 'createNew', array( (object) array( 'name' ), (object) array( 'email' ) ), $message );
    }

    /**
     * Test the expected exception is thrown if contact doesn't exist
     */
    public function testWrongID() {

        $message = 'The contact does not exist. Have you used the correct contact ID?';
        $this->runTryCatchForMethod( 'getSingle', array( '1' ), $message );
        $this->runTryCatchForMethod( 'update', array( '1', 'updated name', 'updated email' ), $message );
        $this->runTryCatchForMethod( 'delete', array( '1' ), $message );

        $message = 'This contact hasn\'t been sent any envelopes.';
        $this->runTryCatchForMethod( 'listEnvelopes', array( '1' ), $message );
    }

    /**
     * Test responses are as expected when a successful calls are made
     */
    public function testGoodResponses() {

        $actual   = Contacts::getSingle( $this->contact->contact_id );
        $expected = $this->managedSuccessfulGetSingleResponse( $this->contact->contact_id, $this->contact->contact_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Contacts::getMultiple();
        $expected = $this->managedSuccessfulGetMultipleResponse( $this->contact->contact_id, $this->contact->contact_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Contacts::createNew( 'Test Contact', 'test@contact.com' );
        $expected = $this->managedSuccessfulCreateContactResponse( $actual->contact_id, $actual->contact_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Contacts::update( $actual->contact_id, 'Updated Contact', 'updated@contact.com' );
        $expected = $this->managedSuccessfulUpdateContactResponse( $actual->contact_id, $actual->contact_updated );
        $this->assertEquals( $expected, $actual );

        $actual   = Contacts::delete( $actual->contact_id );
        $expected = $this->managedSuccessfulDeleteContactResponse( $actual->contact_id );
        $this->assertEquals( $expected, $actual );
    }

    /**
     * Mock expected successful response when a contact is created
     *
     * @param  int    $id      contact id
     * @param  string $created time when contact was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulCreateContactResponse( $id, $created ) {

        return (object) array(
            'http'            => 200,
            'message'         => 'Test Contact has been added to your contact list.',
            'href'            => 'https://api.signable.co.uk/v1/contacts/' . $id,
            'contact_id'      => $id,
            'contact_name'    => 'Test Contact',
            'contact_email'   => 'test@contact.com',
            'contact_created' => $created,
        );
    }

    /**
     * Mock expected successful response when a contact is retrieved
     *
     * @param  int    $id      contact id
     * @param  string $created time when contact was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetSingleResponse( $id, $created ) {

        return (object) array(
            'http'                          => 200,
            'contact_id'                    => $id,
            'contact_name'                  => 'Contact for tests',
            'contact_email'                 => 'contact@for.tests.com',
            'contact_outstanding_documents' => '0',
            'contact_created'               => $created,
        );
    }

    /**
     * Mock expected successful response when a multiple contacts are retrieved
     *
     * @param  int    $id      contact id
     * @param  string $created time when contact was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetMultipleResponse( $id, $created ) {

        $contact = (object) array(
            'contact_id'                    => $id,
            'contact_name'                  => 'Contact for tests',
            'contact_email'                 => 'contact@for.tests.com',
            'contact_outstanding_documents' => '0',
            'contact_created'               => $created,
        );

        return (object) array(
            'http'           => 200,
            'offset'         => 0,
            'limit'          => 10,
            'total_contacts' => '1',
            'contacts'       => array (
                0 => $contact,
            )
        );
    }

    /**
     * Mock expected successful response when a contact is updated
     *
     * @param  int    $id      contact id
     * @param  string $updated time when contact was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulUpdateContactResponse( $id, $updated ) {

        return (object) array(
            'http'            => 200,
            'message'         => 'Updated Contact has been updated in your contact list.',
            'href'            => 'https://api.signable.co.uk/v1/contacts/' . $id,
            'contact_id'      => $id,
            'contact_name'    => 'Updated Contact',
            'contact_email'   => 'updated@contact.com',
            'contact_updated' => $updated,
        );
    }

    /**
     * Mock expected successful response when a contact is deleted
     *
     * @param  int    $id contact id
     * @return object     mock response mimicking API call
     */
    private function managedSuccessfulDeleteContactResponse( $id ) {

        return (object)array(
            'http'          => 200,
            'message'       => 'Updated Contact has been removed from your contact list.',
            'contact_id'    => $id,
            'contact_name'  => 'Updated Contact',
            'contact_email' => 'updated@contact.com',
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
                    Contacts::getSingle( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'getMultiple' :
                try {
                    Contacts::getMultiple( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'createNew' :
                try {
                    Contacts::createNew( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'update' :
                try {
                    Contacts::update( $params[0], $params[1], $params[2] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'delete' :
                try {
                    Contacts::delete( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'listEnvelopes' :
                try {
                    Contacts::listEnvelopes( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );

                }
                break;
        }
    }
}