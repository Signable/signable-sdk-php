Signable PHP SDK Documentation
================

Our PHP SDK is designed to make it even easier to use and integrate with the Signable API. Full API documentation is available on [our developer site](http://developer.signable.co.uk).

---------------------------------------

Installation
-------------

Clone or extract the Signable SDK into the desired directory. [You can download the latest release here](https://github.com/Signable/signable-sdk-php/archive/master.zip).

Initialisation
-------------

To include the required files - if composer is available use:
	require( 'vendor/autoload.php' );

Otherwise use:
	require( 'init.php' );

Pass the API Client your API key using:
	Signable\ApiClient::setApiKey( 'your api key' );

And you're ready to get started!
