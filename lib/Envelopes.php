<?php

namespace Signable;

/**
 * This class contains all the methods relating to Signable envelopes
 *
 */
class Envelopes {

	/**
	 * Create a new envelope on Signable with template documents and send it out
	 *
	 * @param string  $envelopeTitle     required - the title of the new envelope
	 * @param array   $envelopeDocuments required - an array of document objects (created using new Document($documentTitle, $documentTemplateFingerprint, $documentMergeFields)
	 * @param array   $envelopeParties   required - an array of party objects (created using new Party($partyName, $partyEmail, $partyID, $partyMessage)
	 * @param int     $userID            optional - the ID of the user that is sending out the document. This user_id must match an existing User within Signable
	 * @param boolean $passwordProtect   optional - true or false to indicate whether to send this out as a password protected document
	 * @param string  $redirectURL       optional - where to redirect the signer once the document is signed
	 *
	 * @return mixed                     API response
	 */
	public static function createNewWithTemplate( $envelopeTitle, $envelopeDocuments, $envelopeParties, $userID = -1, $passwordProtect = false, $redirectURL = '', $autoRemind = 0, $autoExpire = 0 ) {

		$data = array(
			'envelope_title'     => $envelopeTitle,
			'envelope_documents' => json_encode( $envelopeDocuments ),
			'envelope_parties'   => json_encode( $envelopeParties ),
		);

		if ( -1 !== $userID ) {
			$data['user_id'] = $userID;
		}
		if ( false !== $passwordProtect ) {
			$data['envelope_password_protect'] = $passwordProtect;
		}
		if ( 0 !== $autoExpire) {
			$data['envelope_auto_expire_hours'] = $autoExpire;
		}
		if ( 0 !== $autoRemind) {
			$data['envelope_auto_remind_hours'] = $autoRemind;
		}
		if ( '' !== $redirectURL ) {
			$data['envelope_redirect_url'] = $redirectURL;
		}

		return ApiClient::call( 'envelopes', 'post', $data, new curlWrapper() );
	}

	/**
	 * Create a new envelope on Signable without template documents and send it out
	 *
	 * Note: either document_url or document_file_content AND document_file_name must be set
	 *
	 * @param string  $envelopeTitle     required - the title of the new envelope
	 * @param array   $envelopeDocuments required - an array of document objects (created using new Document($documentTitle, $documentURL, $documentFileContents, $documentFileName)
     * @param array   $envelopeParties   required - an array of party objects (created using new Party($partyName, $partyEmail, $partyRole, $partyMessage)
	 * @param int     $userID            optional - the ID of the user that is sending out the document. This user_id must match an existing User within Signable
	 * @param boolean $passwordProtect   optional - true or false to indicate whether to send this out as a password protected document
	 * @param string  $redirectURL       optional - where to redirect the signer once the document is signed
	 *
	 * @return mixed                     API response
	 */
	public static function createNewWithoutTemplate( $envelopeTitle, $envelopeDocuments, $envelopeParties, $userID = -1, $passwordProtect = false, $redirectURL = '', $autoRemind = 0, $autoExpire = 0 ) {

		$data = array(
			'envelope_title'     => $envelopeTitle,
			'envelope_documents' => json_encode( $envelopeDocuments ),
			'envelope_parties'   => json_encode( $envelopeParties ),
		);

		if ( -1 !== $userID ) {
			$data['user_id'] = $userID;
		}
		if ( false !== $passwordProtect ) {
			$data['envelope_password_protect'] = $passwordProtect;
		}
		if ( 0 !== $autoExpire) {
			$data['envelope_auto_expire_hours'] = $autoExpire;
		}
		if ( 0 !== $autoRemind) {
			$data['envelope_auto_remind_hours'] = $autoRemind;
		}
		if ( '' !== $redirectURL ) {
			$data['envelope_redirect_url'] = $redirectURL;
		}

		return ApiClient::call( 'envelopes', 'post', $data, new curlWrapper() );
	}

	/**
	 * Retrieve a single envelope from Signable
	 *
	 * @param  string $envelopeFingerprint required - the fingerprint of the envelope to retrieve
	 *
	 * @return mixed                       API response
	 */
	public static function getSingle( $envelopeFingerprint ) {

		return ApiClient::call( 'envelopes/' . $envelopeFingerprint, 'get', array(), new curlWrapper() );
	}

	/**
	 * Retrieve multiple envelopes from Signable
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

		return ApiClient::call( 'envelopes', 'get', $data, new curlWrapper() );
	}

	/**
	 * Send a reminder to the next signing party for an envelope on Signable
	 *
	 * @param  string $envelopeFingerprint required - the fingerprint of the envelope to send reminder for
	 *
	 * @return mixed                       API response
	 */
	public static function sendReminder( $envelopeFingerprint ) {

		return ApiClient::call( 'envelopes/' . $envelopeFingerprint . '/remind', 'put', array(), new curlWrapper() );
	}

	/**
	 * Cancel an envelope on Signable
	 *
	 * @param  string $envelopeFingerprint required - the fingerprint of the envelope to cancel
	 *
	 * @return mixed                       API response
	 */
	public static function cancel( $envelopeFingerprint ) {

		return ApiClient::call( 'envelopes/' . $envelopeFingerprint . '/cancel', 'put', array(), new curlWrapper() );
	}

	/**
	 * Expire an envelope on Signable (silently cancel a document)
	 *
	 * @param  string $envelopeFingerprint required - the fingerprint of the envelope to expire
	 *
	 * @return mixed                       API response
	 */
	public static function expire( $envelopeFingerprint ) {

		return ApiClient::call( 'envelopes/' . $envelopeFingerprint . '/expire', 'put', array(), new curlWrapper() );
	}

	/**
	 * Delete an envelope on Signable
	 *
	 * @param  string $envelopeFingerprint required - the fingerprint of the envelope to delete
	 *
	 * @return mixed          API response
	 */
	public static function delete( $envelopeFingerprint ) {

		return ApiClient::call( 'envelopes/' . $envelopeFingerprint, 'delete', array(), new curlWrapper() );
	}
}
