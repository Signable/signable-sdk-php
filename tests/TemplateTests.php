<?php

namespace Signable;

class TemplateTests extends TestCase {

    private $template;

    /**
     * Setup anything required for the contact tests - ran before each test
     */
    protected function setUp() {

        $all = Templates::getMultiple();
        $this->template = $all->templates[0];
    }

    /**
     * Test the expected exception is thrown if parameters are missing
     */
    public function testMissingParameters() {

        $message = 'To retrieve a single template, please pass in a template fingerprint.';
        $this->runTryCatchForMethod( 'getSingle', array( null ), $message );

        $message = 'To delete a template, please pass in a template fingerprint.';
        $this->runTryCatchForMethod( 'delete', array( '' ), $message );
    }

    /**
     * Test the expected exception is thrown if incorrect parameter is used
     */
    public function testInvalidParam() {

        $message = 'Array to string conversion';
        $this->runTryCatchForMethod( 'getSingle', array( array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( array(), array() ), $message );
        $this->runTryCatchForMethod( 'delete', array( array() ), $message );

        $message = 'Object of class stdClass could not be converted to string';
        $this->runTryCatchForMethod( 'getSingle', array( (object) array() ), $message );
        $this->runTryCatchForMethod( 'getMultiple', array( (object) array(), (object) array() ), $message );
        $this->runTryCatchForMethod( 'delete', array( (object) array() ), $message );
    }

    /**
     * Test the expected exception is thrown if template doesn't exist
     */
    public function testWrongID() {

        $message = 'The template does not exist. Have you used the correct template fingerprint?';
        $this->runTryCatchForMethod( 'getSingle', array( '1' ), $message );
        $this->runTryCatchForMethod( 'delete', array( '1' ), $message );
    }

    /**
     * Test responses are as expected when a successful calls are made
     */
    public function testGoodResponses() {

        $actual   = Templates::getSingle( $this->template->template_fingerprint );
        $expected = $this->managedSuccessfulGetSingleResponse( $this->template->template_id, $this->template->template_fingerprint, $this->template->template_title );
        $this->assertEquals( $expected->template_id, $actual->template_id );
        $this->assertEquals( $expected->template_fingerprint, $actual->template_fingerprint );
        $this->assertEquals( $expected->template_title, $actual->template_title );

        $actual   = Templates::getMultiple();
        $expected = $this->managedSuccessfulGetMultipleResponse( $this->template->template_id );
        $this->assertEquals( $expected->offset, $actual->offset );
        $this->assertEquals( $expected->limit, $actual->limit );
        $this->assertEquals( $expected->total_templates, $actual->total_templates );
        $this->assertEquals( count( $expected->templates ), count( $actual->templates ) );
    }

    /**
     * Mock expected successful response when a template is retrieved
     *
     * @param  int    $id          template id
     * @param  string $fingerprint template fingerprint
     * @param  string $title       template title
     * @return object mock response mimicking API call
     */
    private function managedSuccessfulGetSingleResponse( $id, $fingerprint, $title ) {

        return (object) array(
            'http'                           => 200,
            'template_id'                    => $id,
            'template_fingerprint'           => $fingerprint,
            'template_title'                 => $title,
        );
    }

    /**
     * Mock expected successful response when a multiple templates are retrieved
     *
     * @param  int    $id      template id
     * @return object          mock response mimicking API call
     */
    private function managedSuccessfulGetMultipleResponse( $id ) {

        $template = (object) array(
            'template_id'                    => $id,
        );

        return (object) array(
            'http'            => 200,
            'offset'          => 0,
            'limit'           => 10,
            'total_templates' => '1',
            'templates'       => array (
                0 => $template,
            )
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
                    Templates::getSingle( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'getMultiple' :
                try {
                    Templates::getMultiple( $params[0], $params[1] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;

            case 'delete' :
                try {
                    Templates::delete( $params[0] );
                } catch( \Exception $e ) {
                    $this->assertEquals( $message, $e->getMessage() );
                }
                break;
        }
    }
}