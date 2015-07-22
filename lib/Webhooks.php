<?php

namespace Signable;

/**
 * This class contains all the methods relating to Signable webhooks
 *
 */
class Webhooks {

	/**
	 * Create a new webhook on signable
	 *
	 * @param  string $webhookType required - type of webhook to create ("send-envelope", "signed-envelope" or "all")
	 * @param  string $webhookURL  required - the URL of the new webhook
	 *
	 * @return mixed               API response
	 */
	public static function createNew( $webhookType, $webhookURL ) {

		$data = array(
			'webhook_type' => $webhookType,
			'webhook_url'  => $webhookURL,
		);

		return ApiClient::call( 'webhooks', 'post', $data, new curlWrapper() );
	}

	/**
	 * Retrieve a single webhook from Signable
	 *
	 * @param  int $webhookID required - the ID of the webhook to retrieve
	 *
	 * @return mixed          API response
	 */
	public static function getSingle( $webhookID ) {

		return ApiClient::call( 'webhooks/' . $webhookID, 'get', array(), new curlWrapper() );
	}

	/**
	 * Retrieve multiple webhooks from Signable
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

		return ApiClient::call( 'webhooks', 'get', $data, new curlWrapper() );
	}

	/**
	 * Update a webhook on Signable
	 *
	 * Either webhook type or webhook URL are required
	 *
	 * @param  int    $webhookID   required - the ID of the webhook to update
	 * @param  string $webhookType optional - updated webhook type ("send-envelope", "signed-envelope" or "all")
	 * @param  string $webhookURL  optional - the updated URL for the webhook
	 *
	 * @return mixed               API response
	 */
	public static function update( $webhookID, $webhookType = '', $webhookURL = '' ) {

		$data = array();

		if ( '' != $webhookType ) {
			$data['webhook_type'] = $webhookType;
		}

		if ( '' != $webhookURL ) {
			$data['webhook_url'] = $webhookURL;
		}

		return ApiClient::call( 'webhooks/' . $webhookID, 'put', $data, new curlWrapper() );
	}

	/**
	 * Delete a webhook on Signable
	 *
	 * @param  int $webhookID required - the ID of the webhook to delete
	 *
	 * @return mixed          API response
	 */
	public static function delete( $webhookID ) {

		return ApiClient::call( 'webhooks/' . $webhookID, 'delete', array(), new curlWrapper() );
	}
}