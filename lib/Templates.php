<?php

namespace Signable;

/**
 * This class contains all the methods relating to Signable templates
 *
 */
class Templates {

	/**
	 * Retrieve a single template from Signable
	 *
	 * @param  int $templateFingerprint required - the fingerprint of the template to retrieve
	 *
	 * @return mixed                    API response
	 */
	public static function getSingle( $templateFingerprint ) {

		return ApiClient::call( 'templates/' . $templateFingerprint, 'get', array(), new curlWrapper() );
	}

	/**
	 * Retrieve multiple templates from Signable
	 *
	 * @param  int $offset optional - the first record to retrieve
	 * @param  int $limit  optional - the number of results to return
	 *
	 * @return mixed       API response
	 */
	public static function getMultiple( $offset = 0, $limit = 10 ) {

		$data = array(
			'offset'  => $offset,
			'limit'   => $limit,
		);

		return ApiClient::call( 'templates', 'get', $data, new curlWrapper() );
	}

	/**
	 * Delete a template on Signable
	 *
	 * @param  int $templateFingerprint required - the fingerprint of the template to delete
	 *
	 * @return mixed                    API response
	 */
	public static function delete( $templateFingerprint ) {

		return ApiClient::call( 'templates/' . $templateFingerprint, 'delete', array(), new curlWrapper() );
	}
}