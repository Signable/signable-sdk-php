<?php

namespace Signable;

/**
 * This is the client class for making curl requests to the Signable API
 *
 * Each request "get", "post", "put" and "delete" is handled here
 */
class curlWrapper {

    /**
     * Initialise the cURL request
     *
     * @return resource cURL handle on success, false on failure
     */
    public function curlInitialise() {

        return curl_init();
    }

    /**
     * Set options for the cURL transfer
     *
     * @param  resource $ch cURL handle
     * @param  array $curlOptions options to apply to the request
     * @return bool                  true on success, false on failure
     */
    public function curlSetOptions( $ch, $curlOptions ) {

        return curl_setopt_array( $ch, $curlOptions );
    }

    /**
     * Execute the cURL request
     *
     * @param  resource $ch cURL handle
     * @return object       API response
     */
    public function curlExecute( $ch ) {

        return curl_exec( $ch );
    }

    /**
     * Close the current cURL session
     *
     * @param  resource $ch cURL handle
     * @return void
     */
    public function curlClose( $ch ) {

        curl_close( $ch );
    }

    /**
     * Setup the cURL options array as required for the request
     *
     * @param  string $type type of API request
     * @param  string $endpoint required endpoint for the request
     * @param  array $data data required for API request
     * @return array            options required for the current cURL request
     */
    public function setCurlOptions( $type, $endpoint, $data ) {

        $curlOptions = array(
            CURLOPT_USERPWD        => ApiClient::$clientApiKey . ':' . ApiClient::$clientPassword,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        );

        $curlURL = ApiClient::$apiURL . $endpoint;

        switch ( $type ) {

            case 'post':
                $curlOptions = $curlOptions + array(
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => http_build_query( $data ),
                    );
                break;

            case 'put':
                $curlOptions = $curlOptions + array(
                        CURLOPT_CUSTOMREQUEST => 'PUT',
                        CURLOPT_POSTFIELDS => http_build_query( $data ),
                    );
                break;

            case 'delete':
                $curlOptions = $curlOptions + array(
                        CURLOPT_CUSTOMREQUEST => 'DELETE',
                        CURLOPT_POSTFIELDS => $data,
                    );
                break;

            case 'get':
                $curlURL .= '?&' . http_build_query( $data );
                $curlOptions = $curlOptions + array();
                break;
        }

        $curlOptions = $curlOptions + array(
                CURLOPT_URL => $curlURL
            );

        return $curlOptions;
    }
}