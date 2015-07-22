<?php

namespace Signable\Error;

use Exception;

class ApiError extends Exception {

    public function __construct (
        $message,
        $httpCode  = null,
        $errorCode = null,
        $response  = null
    ) {
        parent::__construct( $message );
        $this->httpStatus = $httpCode;
        $this->code       = $errorCode;
        $this->jsonBody   = $response;
    }
}