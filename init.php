<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

// API Client
require( dirname(__FILE__) . '/lib/ApiClient.php' );
require( dirname(__FILE__) . '/lib/curlWrapper.php' );
require( dirname(__FILE__) . '/lib/Error/ApiError.php' );

// Method files
require( dirname(__FILE__) . '/lib/Contacts.php' );
require( dirname(__FILE__) . '/lib/Envelopes.php' );
require( dirname(__FILE__) . '/lib/Teams.php' );
require( dirname(__FILE__) . '/lib/Templates.php' );
require( dirname(__FILE__) . '/lib/Users.php' );
require( dirname(__FILE__) . '/lib/Webhooks.php' );

// Objects
require( dirname(__FILE__) . '/lib/DocumentWithTemplate.php' );
require( dirname(__FILE__) . '/lib/DocumentWithoutTemplate.php' );
require( dirname(__FILE__) . '/lib/MergeField.php' );
require( dirname(__FILE__) . '/lib/Party.php' );