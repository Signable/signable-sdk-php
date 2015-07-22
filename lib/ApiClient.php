<?php

namespace Signable;

/**
 * This is the client class for making curl requests to the Signable API
 *
 * Each request "get", "post", "put" and "delete" is handled here
 */
class ApiClient {

    // credentials
    public static $clientApiKey;
    public static $clientPassword = 'x';

    // base url for api calls
    public static $apiURL = 'https://api.signable.co.uk/v1/';

	// api call response format
	public static $responseFormat = 'json';

	/**
	 * Set the API key for the client
	 *
	 * @param string $clientApiKey API key
	 */
	public static function setApiKey( $clientApiKey ) {

		self::$clientApiKey = $clientApiKey;
	}

	/**
	 * Set response format for all API calls
	 *
	 * Note: will default to "json" if anything other than "xml" is requested
	 *
	 * @param string $format the desired response format - accepts "xml" or "json"
	 */
	public static function setResponseFormat( $format = 'json' ) {

		self::$responseFormat = 'xml' == $format ? $format : 'json';
	}

    /**
     * Function to process any API call required using PHP curl
     *
     * Headers are built depending on type of call made and the url supplied
     * Options are collated and curl executes the request
     * The response is decoded from json and returned
     *
     * @param  string $endpoint required endpoint for the request
     * @param  string $type     type of API request
     * @param  array  $data     data required for API request
     * @return mixed            API response
     */
    public static function call( $endpoint, $type, $data = array(), $wrapper ) {

        $endpoint    = 'xml' != self::$responseFormat ? $endpoint : $endpoint . '.xml';

        $ch          = $wrapper->curlInitialise();

        $curlOptions = $wrapper->setCurlOptions( $type, $endpoint, $data );
        $wrapper->curlSetOptions( $ch, $curlOptions );

        $response    = $wrapper->curlExecute( $ch );
        $result      = json_decode( $response );

        $wrapper->curlClose( $ch );

        $errorCodes = array( 400, 401, 403, 404 );
        if ( in_array( $result->http, $errorCodes ) ) {

            self::handleApiError( $result, $response );
        } else {
            return $result;
        }
    }

    /**
     * If the response generated an error code throw an exception with the required information
     *
     * @param  object $response     encoded API response
     * @param  string $jsonResponse raw JSON API response
     * @throws Error\ApiError
     *
     * @return void
     */
    public static function handleApiError( $response, $jsonResponse ) {

        $httpCode  = $response->http;
        $message   = isset( $response->message ) ? $response->message : null;
        $errorCode = isset( $response->code ) ? $response->code : null;

        throw new Error\ApiError( $message, $httpCode, $errorCode, $jsonResponse );
    }
}