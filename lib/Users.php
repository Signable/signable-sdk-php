<?php

namespace Signable;

/**
 * This class contains all the methods relating to Signable users
 *
 */
class Users {

	/**
	 * Create a new user on signable
	 *
	 * @param  string $userName  required - the name of the new user
	 * @param  string $userEmail required - the email of the new user
	 * @param  int $teamID optional - a valid team_id
	 *
	 * @return mixed             API response
	 */
	public static function createNew( $userName, $userEmail, $teamID = 0 ) {

		$data = array(
			'user_name'  => $userName,
			'user_email' => $userEmail
		);

		if($teamID > 0) {
			$data['team_id'] = $teamID;
		}

		return ApiClient::call( 'users', 'post', $data, new curlWrapper() );
	}

	/**
	 * Retrieve a single user from Signable
	 *
	 * @param  int $userID required - the ID of the user to retrieve
	 *
	 * @return mixed       API response
	 */
	public static function getSingle( $userID ) {

		return ApiClient::call( 'users/' . $userID, 'get', array(), new curlWrapper() );
	}

	/**
	 * Retrieve multiple users from Signable
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

		return ApiClient::call( 'users', 'get', $data, new curlWrapper() );
	}

	/**
	 * Update a users name or email on Signable
	 *
	 * Note: either name or email are required
	 *
	 * @param  int    $userID    required - the ID of the user to update
	 * @param  string $userName  optional - the updated name for the user
	 * @param  string $userEmail optional - the updated email for the user
	 *
	 * @return mixed             API response
	 */
	public static function update( $userID, $userName = '', $userEmail = '', $teamID = 0 ) {

		$data = array();

		if ( '' != $userName ) {
			$data['user_name'] = $userName;
		}

		if ( '' != $userEmail ) {
			$data['user_email'] = $userEmail;
		}

		if ($teamID > 0) {
			$data['team_id'] = $teamID;
		}

		return ApiClient::call( 'users/' . $userID, 'put', $data, new curlWrapper() );
	}

	/**
	 * Delete a user on Signable
	 *
	 * @param  int $userID required - the ID of the user to delete
	 *
	 * @return mixed       API response
	 */
	public static function delete( $userID ) {

		return ApiClient::call( 'users/' . $userID, 'delete', array(), new curlWrapper() );
	}
}