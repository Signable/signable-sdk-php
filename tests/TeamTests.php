<?php

namespace Signable;

class TeamTests extends TestCase {

    private $team;

    /**
     * Setup anything required for the team tests - ran before each test
     */
    protected function setUp() {

        $this->team = Teams::createNew('Team for tests');
    }

    /**
     * Remove anything required for the team tests - ran after each test
     */
    protected function tearDown() {
//        DELETING DOESNT CURRENTLY WORK FOR TEAMS
//        $teams = Teams::getMultiple();
//        foreach ( $teams->teams as $team ) {
//            Teams::delete( $team->team_id );
//        }
    }

    /**
     * Test the expected exception is thrown if parameters are missing
     */
    public function testMissingParameters() {

        $message = 'The team name is missing. To be able to create a new team, you must provide a name.';
        $this->runTryCatchForMethod( 'createNew', array( '', array() ), $message );

        $message = 'To retrieve a single team, please pass in a team ID.';
        $this->runTryCatchForMethod( 'getSingle', array( null ), $message );

        $message = 'To delete a team, please pass in a team ID.';
        $this->runTryCatchForMethod( 'delete', array( '' ), $message );

        $message = 'To update a team, please pass in a team ID.';
        $this->runTryCatchForMethod( 'update', array( '', '', array() ), $message );
    }

    /**
     * Test the expected exception is thrown if incorrect parameter is used
     */
    public function testInvalidParam() {

        $message = 'Array to string conversion';
        $this->runTryCatchForMethod( 'getSingle', array( array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( array(), array() ), $message );
        $this->runTryCatchForMethod( 'update', array( array(), array(), array() ), $message );
        $this->runTryCatchForMethod( 'delete', array( array() ), $message );

        $message = 'Object of class stdClass could not be converted to string';
        $this->runTryCatchForMethod( 'getSingle', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( (object) array(), (object) array() ), $message );
        $this->runTryCatchForMethod( 'update', array( (object) array(), (object) array(), array() ), $message );
        $this->runTryCatchForMethod( 'delete', array( (object) array() ), $message );

        $message = 'Team name must be a string to create a new team';
        $this->runTryCatchForMethod( 'createNew', array( array( 'name', 'something' ), array() ), $message );
        $this->runTryCatchForMethod( 'createNew', array( (object) array( 'name' ), array() ), $message );
    }

    /**
     * Test the expected exception is thrown if team doesn't exist
     */
    public function testWrongID() {

        $message = 'The team does not exist. Have you used the correct team ID?';
        $this->runTryCatchForMethod( 'getSingle', array( '1' ), $message );
        $this->runTryCatchForMethod( 'update', array( '1', 'updated name', array() ), $message );

        $message = 'Sorry, but you need to have at least one user in a team that can manage Users and teams. This is to avoid being in a situation where no-one can manage the permissions for your account!';
        $this->runTryCatchForMethod( 'delete', array( '1' ), $message );
    }

    /**
     * Test responses are as expected when a successful calls are made
     */
    public function testGoodResponses() {

        $actual   = Teams::getSingle( $this->team->team_id );
        $expected = $this->managedSuccessfulGetSingleResponse( $this->team->team_id, $this->team->team_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Teams::getMultiple();
        $expected = $this->managedSuccessfulGetMultipleResponse( $this->team->team_id, $this->team->team_created );
        $this->assertEquals( $expected->http, $actual->http );
        $this->assertEquals( $expected->offset, $actual->offset );
        $this->assertEquals( $expected->limit, $actual->limit );
        $this->assertInternalType( 'object', $actual->teams[0] );

        $actual   = Teams::createNew( 'Test Team', array( 'team_permission_own' => true ) );
        $expected = $this->managedSuccessfulCreateTeamResponse( $actual->team_id, $actual->team_created );
        $this->assertEquals( $expected, $actual );

        $actual   = Teams::update( $actual->team_id, 'Updated Team', array( 'team_permission_own' => true ) );
        $expected = $this->managedSuccessfulUpdateTeamResponse( $actual->team_id, $actual->team_updated );
        $this->assertEquals( $expected, $actual );
    }

    /**
     * Mock expected successful response when a team is created
     *
     * @param  int    $id      team id
     * @param  string $created time when team was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulCreateTeamResponse( $id, $created ) {

        return (object) array(
            'http'                       => 200,
            'message'                    => 'Test Team has been added to your teams with standard permissions.',
            'href'                       => 'https://api.signable.co.uk/v1/teams/' . $id,
            'team_id'                    => $id,
            'team_name'                  => 'Test Team',
            'team_permission_own'        => true,
            'team_permission_users'      => false,
            'team_permission_branding'   => false,
            'team_permission_apps'       => false,
            'team_permission_settings'   => false,
            'team_permission_company'    => false,
            'team_created'               => $created,
        );
    }

    /**
     * Mock expected successful response when a team is retrieved
     *
     * @param  int    $id      team id
     * @param  string $created time when team was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetSingleResponse( $id, $created ) {

        return (object) array(
            'http'                       => 200,
            'team_id'                    => $id,
            'team_name'                  => 'Team for tests',
            'team_users'                 => '0',
            'team_permission_own'        => false,
            'team_permission_users'      => false,
            'team_permission_branding'   => false,
            'team_permission_apps'       => false,
            'team_permission_settings'   => false,
            'team_permission_company'    => false,
            'team_updated'               => null,
            'team_created'               => $created,
        );
    }

    /**
     * Mock expected successful response when a multiple teams are retrieved
     *
     * @param  int    $id      team id
     * @param  string $created time when team was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetMultipleResponse( $id, $created ) {

        $team = (object) array(
            'team_id'                    => $id,
            'team_name'                  => 'Team for tests',
            'team_users'                 => '0',
            'team_permission_own'        => false,
            'team_permission_users'      => false,
            'team_permission_branding'   => false,
            'team_permission_apps'       => false,
            'team_permission_settings'   => false,
            'team_permission_company'    => false,
            'team_updated'               => null,
            'team_created'               => $created,
        );

        return (object) array(
            'http'           => 200,
            'offset'         => 0,
            'limit'          => 10,
            'total_teams'    => '1',
            'teams'          => array (
                0 => $team,
            )
        );
    }

    /**
     * Mock expected successful response when a team is updated
     *
     * @param  int    $id      team id
     * @param  string $updated time when team was created
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulUpdateTeamResponse( $id, $updated ) {

        return (object)array(
            'http'                     => 200,
            'message'                  => 'Updated Team has been updated in your teams.',
            'href'                     => 'https://api.signable.co.uk/v1/team/' . $id,
            'team_id'                  => $id,
            'team_name'                => 'Updated Team',
            'team_users'               => '0',
            'team_permission_own'      => true,
            'team_permission_users'    => false,
            'team_permission_branding' => false,
            'team_permission_apps'     => false,
            'team_permission_settings' => false,
            'team_permission_company'  => false,
            'team_updated'             => $updated,
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
                    Teams::getSingle( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'getMultiple' :
                try {
                    Teams::getMultiple( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'createNew' :
                try {
                    Teams::createNew( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'update' :
                try {
                    Teams::update( $params[0], $params[1], $params[2] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'delete' :
                try {
                    Teams::delete( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;
        }
    }
}