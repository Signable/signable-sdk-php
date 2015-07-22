<?php

namespace Signable;

class UserTests extends TestCase {

    private $user;

    /**
     * Setup anything required for the user tests - ran before each test
     */
    protected function setUp() {

        $user       = Users::createNew('User for tests', 'user@for.tests.com');
        $this->user = Users::getSingle( $user->user_id );
    }

    /**
     * Remove anything required for the user tests - ran after each test
     */
    protected function tearDown() {

        $users = Users::getMultiple();
        foreach ( $users->users as $user ) {
            Users::delete( $user->user_id );
        }
    }

    /**
     * Test the expected exception is thrown if parameters are missing
     */
    public function testMissingParameters() {

        $message = 'The user name is missing. To be able to create a new user, you must provide a name.';
        $this->runTryCatchForMethod( 'createNew', array( '', '' ), $message );

        $message = 'The user email is missing. To be able to create a new user, you must provide an email address.';
        $this->runTryCatchForMethod( 'createNew', array( 'user', '' ), $message );

        $message = 'To retrieve a single user, please pass in a user ID.';
        $this->runTryCatchForMethod( 'getSingle', array( null ), $message );

        $message = 'To delete a user, please pass in a user ID.';
        $this->runTryCatchForMethod( 'delete', array( '' ), $message );

        $message = 'To update a user, please pass in a user ID.';
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
     * Test the expected exception is thrown if user doesn't exist
     */
    public function testWrongID() {

        $message = 'The user does not exist. Have you used the correct user ID?';
        $this->runTryCatchForMethod( 'getSingle', array( '1' ), $message );
        $this->runTryCatchForMethod( 'update', array( '1', 'updated name', 'updated email' ), $message );
        $this->runTryCatchForMethod( 'delete', array( '1' ), $message );
    }

    /**
     * Test responses are as expected when a successful calls are made
     */
    public function testGoodResponses() {

        $actual   = Users::getSingle( $this->user->user_id );
        $expected = $this->managedSuccessfulGetSingleResponse( $this->user->user_id, $this->user->user_added, $this->user->user_last_updated );
        $this->assertEquals( $expected, $actual );

        $actual   = Users::getMultiple();
        $expected = $this->managedSuccessfulGetMultipleResponse( $this->user->user_id, $this->user->user_added );
        $this->assertEquals( $expected, $actual );

        $actual   = Users::createNew( 'Test User', 'test@user.com' );
        $expected = $this->managedSuccessfulCreateUserResponse( $actual->user_id, $actual->user_added );
        $this->assertEquals( $expected, $actual );

        $actual   = Users::update( $actual->user_id, 'Updated User', 'updated@user.com' );
        $expected = $this->managedSuccessfulUpdateUserResponse( $actual->user_id, $actual->user_updated );
        $this->assertEquals( $expected, $actual );

        $actual   = Users::delete( $actual->user_id );
        $expected = $this->managedSuccessfulDeleteUserResponse( $actual->user_id );
        $this->assertEquals( $expected, $actual );
    }

    /**
     * Mock expected successful response when a user is created
     *
     * @param  int    $id      user id
     * @param  string $created time when user was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulCreateUserResponse( $id, $created ) {

        return (object) array(
            'http'         => 200,
            'message'      => 'Test User has been added to your user list.',
            'href'         => 'https://api.signable.co.uk/v1/users/' . $id,
            'user_id'      => $id,
            'user_name'    => 'Test User',
            'user_email'   => 'test@user.com',
            'user_added'   => $created,
        );
    }

    /**
     * Mock expected successful response when a user is retrieved
     *
     * @param  int    $id user id
     * @param  string $created time when user was created
     * @param  string $updated time when user was last updated
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetSingleResponse( $id, $created, $updated ) {

        return (object)array(
            'http'              => 200,
            'user_id'           => $id,
            'user_name'         => 'User for tests',
            'user_email'        => 'user@for.tests.com',
            'user_added'        => $created,
            'user_last_updated' => $updated,
        );
    }

    /**
     * Mock expected successful response when a multiple users are retrieved
     *
     * @param  int    $id      user id
     * @param  string $created time when user was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetMultipleResponse( $id, $created ) {

        $user = (object) array(
            'user_id'           => $id,
            'user_name'         => 'User for tests',
            'user_email'        => 'user@for.tests.com',
            'user_added'        => $created,
            'user_last_updated' => null,
        );

        return (object) array(
            'http'        => 200,
            'offset'      => 0,
            'limit'       => 10,
            'total_users' => '1',
            'users'       => array (
                0 => $user,
            )
        );
    }

    /**
     * Mock expected successful response when a user is updated
     *
     * @param  int    $id      user id
     * @param  string $updated time when user was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulUpdateUserResponse( $id, $updated ) {

        return (object) array(
            'http'         => 200,
            'message'      => 'Updated User has been updated in your user list.',
            'href'         => 'https://api.signable.co.uk/v1/users/' . $id,
            'user_id'      => $id,
            'user_name'    => 'Updated User',
            'user_email'   => 'updated@user.com',
            'user_updated' => $updated,
        );
    }

    /**
     * Mock expected successful response when a user is deleted
     *
     * @param  int    $id user id
     * @return object     mock response mimicking API call
     */
    private function managedSuccessfulDeleteUserResponse( $id ) {

        return (object)array(
            'http'       => 200,
            'message'    => 'Updated User has been removed from your user list.',
            'user_id'    => $id,
            'user_email' => 'updated@user.com',
            'user_name'  => 'Updated User',

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
                    Users::getSingle( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'getMultiple' :
                try {
                    Users::getMultiple( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'createNew' :
                try {
                    Users::createNew( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'update' :
                try {
                    Users::update( $params[0], $params[1], $params[2] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'delete' :
                try {
                    Users::delete( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;
        }
    }
}