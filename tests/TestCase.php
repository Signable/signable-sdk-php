<?php

namespace Signable;

/**
 * Base class for Signable test cases
 */
class TestCase extends \PHPUnit_Framework_TestCase {

    public $mockCurlWrapper;

    /**
     * Setup the test suite - run before each test
     *
     * Anything required for methods across multiple test classes should go here
     */
    protected function setUp() {

        $this->mockCurlWrapper = $this->getMockBuilder( 'curlWrapper' )
                                      ->setMethods( array(
                                          'curlInitialise',
                                          'curlSetOptions',
                                          'curlExecute',
                                          'curlClose',
                                          'setCurlOptions',
                                      ))
                                      ->getMock();

        ApiClient::setApiKey( '0742b82b9085c3d1c4b5d545bec6cbea' );
	}
}