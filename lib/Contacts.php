<?php

namespace Signable;

/**
 * This class contains all the methods relating to Signable contacts
 *
 */
class Contacts {

    /**
     * Create a new contact on signable
     *
     * @param  string $contactName  required - the name of the new contact
     * @param  string $contactEmail required - the email of the new contact
     * @return mixed                API response
     *
     * @throws Error\ApiError
     */
	public static function createNew( $contactName, $contactEmail ) {

        if ( !is_string( $contactName ) || !is_string( $contactEmail ) ) {
            throw new Error\ApiError( 'Contact name and email must be a string to create a new contact' );
        }

		$data = array(
			'contact_name'  => $contactName,
			'contact_email' => $contactEmail,
		);

		return ApiClient::call( 'contacts', 'post', $data, new curlWrapper() );
	}

    /**
     * Retrieve a single contact from Signable
     *
     * @param  int   $contactID required - the ID of the contact to retrieve
     * @return mixed            API response
     *
     * @throws Error\ApiError
     */
	public static function getSingle( $contactID ) {

        if ( !isset( $contactID ) || '' == $contactID ) {
            throw new Error\ApiError( 'To retrieve a single contact, please pass in a contact ID.' );
        }

		return ApiClient::call( 'contacts/' . $contactID, 'get', array(), new curlWrapper() );
	}

	/**
	 * Retrieve multiple contacts from Signable
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

		return ApiClient::call( 'contacts', 'get', $data, new curlWrapper() );
	}

    /**
     * Update a contact on Signable
     *
     * Either name or email are required
     *
     * @param  int    $contactID    required - the ID of the contact to update
     * @param  string $contactName  optional - the updated name for the contact
     * @param  string $contactEmail optional - the updated email for the contact
     * @return mixed                API response
     *
     * @throws Error\ApiError
     */
	public static function update( $contactID, $contactName = '', $contactEmail = '' ) {

        if ( !is_string( $contactName ) || !is_string( $contactEmail ) ) {
            throw new Error\ApiError( 'Contact name and email must be a string to update a contact' );
        }

		$data = array();

		if ( '' != $contactName ) {
			$data['contact_name'] = $contactName;
		}

		if ( '' != $contactEmail ) {
			$data['contact_email'] = $contactEmail;
		}

		return ApiClient::call( 'contacts/' . $contactID, 'put', $data, new curlWrapper() );
	}

	/**
	 * Delete a contact on Signable
	 *
	 * @param  int $contactID required - the ID of the contact to delete
	 *
	 * @return mixed          API response
	 */
	public static function delete( $contactID ) {

		return ApiClient::call( 'contacts/' . $contactID, 'delete', array(), new curlWrapper() );
	}

	/**
	 * List all envelopes for a contact on Signable
	 *
	 * @param  int $contactID required - the ID of the contact to retrieve envelopes for
	 *
	 * @return mixed          API response
	 */
	public static function listEnvelopes( $contactID ) {

		return ApiClient::call( 'contacts/' . $contactID . '/envelopes', 'get', array(), new curlWrapper() );
	}
}