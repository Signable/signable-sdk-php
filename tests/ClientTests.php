<?php

namespace Signable;

class ClientTests extends TestCase {

    /**
     * Test exception is thrown as expected for API handle error method
     *
     * @expectedException     Signable\Error\ApiError
     * @expectedExceptionCode 10003
     */
    public function testHandleApiError() {

        $response          = new \stdClass();
        $response->http    = 404;
        $response->code    = 10003;
        $response->message = 'The URL you are looking for does not exist.';
        $jsonResponse      = json_encode( $response );

        ApiClient::handleApiError( $response, $jsonResponse );
    }

    /**
     * Test the API call function when passing a good request
     *
     * try/catch used in case an API error occurs and an exception is thrown
     */
    public function testCallWithGoodRequest() {

        $this->setupMockCurlFunctions();

        $this->mockCurlWrapper->expects( $this->any() )
                              ->method( 'curlExecute' )
                              ->will( $this->onConsecutiveCalls(
                                  $this->returnResponseCode( 200 ),
                                  $this->returnResponseCode( 202 )
                              ));

        try {
            $this->assertEquals(json_decode($this->returnResponseCode(200)), ApiClient::call('contacts/404396', 'get', array(), $this->mockCurlWrapper));
        } catch ( \Exception $e ) {
            $this->assertNull( $e->getMessage(), 'Http Code "200" threw unexpected Exception in ' . $e->getFile() . ', Line: ' . $e->getLine() );
        }
        try {
            $this->assertEquals(json_decode($this->returnResponseCode(202)), ApiClient::call('contacts/404396', 'get', array(), $this->mockCurlWrapper));
        } catch ( \Exception $e ) {
            $this->assertNull( $e->getMessage(), 'Http Code "202" threw unexpected Exception in ' . $e->getFile() . ', Line: ' . $e->getLine() );
        }
    }

    /**
     * Test the API call function when passing a bad request
     *
     * @expectedException Signable\Error\ApiError
     */
    public function testCallWithBadRequest() {

        $this->setupMockCurlFunctions();

        $this->mockCurlWrapper->expects( $this->any() )
                              ->method( 'curlExecute' )
                              ->will( $this->onConsecutiveCalls(
                                  $this->returnResponseCode( 400 ),
                                  $this->returnResponseCode( 401 ),
                                  $this->returnResponseCode( 403 ),
                                  $this->returnResponseCode( 404 )
                              ));

        ApiClient::call( 'contacts/100', 'get', array(), $this->mockCurlWrapper );
        ApiClient::call( 'contacts/100', 'get', array(), $this->mockCurlWrapper );
        ApiClient::call( 'contacts/100', 'get', array(), $this->mockCurlWrapper );
        ApiClient::call( 'contacts/100', 'get', array(), $this->mockCurlWrapper );
    }

    /**
     * Returns response in format to mimic the API call
     *
     * @param  int    $httpCode http response code
     * @return string           json response
     */
    private function returnResponseCode( $httpCode ) {

        return json_encode( array(
            'http'                          => $httpCode,
        ));
    }

    /**
     *  Mock up the curl functions required for client tests
     */
    private function setupMockCurlFunctions() {

        $this->mockCurlWrapper->expects( $this->any() )
                              ->method( 'curlInitialise' )
                              ->will( $this->returnValue( 'curlHandle' ) );
        $this->mockCurlWrapper->expects( $this->any() )
                              ->method( 'setCurlOptions' )
                              ->will( $this->returnValue( array() ) );
        $this->mockCurlWrapper->expects( $this->any() )
                              ->method( 'curlSetOptions' )
                              ->will( $this->returnValue( true ) );
        $this->mockCurlWrapper->expects( $this->any() )
                              ->method( 'curlClose' )
                              ->will( $this->returnValue( true ) );
    }
}