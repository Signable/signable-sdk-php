Signable PHP SDK Documentation
================

Our PHP SDK is designed to make it even easier to use and integrate with the Signable API. Full API documentation is available on [our developer site](http://developer.signable.co.uk).

---------------------------------------

Installation
-------------

Add the Signable PHP SDK to your composer.json file. If you are not using Composer, you should be. It's an excellent way to manage dependencies in your PHP application.

{  
  "require": {
    "signable/signable-php": "*"
  }
}
Then at the top of your PHP script require the autoloader:

	require 'vendor/autoload.php';

Alternative: Install from zip
-----------------------------

If you are not using Composer, simply download and install the latest packaged release of the library as a zip.

[You can download the latest release here](https://github.com/Signable/signable-sdk-php/archive/master.zip).

Then require the library from package:

require("path/to/signable-sdk-php/init.php");

Initialisation
-------------

Pass the API Client your API key using:

	Signable\ApiClient::setApiKey( 'your api key' );

And you're ready to get started!
