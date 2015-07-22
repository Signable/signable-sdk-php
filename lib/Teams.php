<?php

namespace Signable;

/**
 * This class contains all the methods relating to Signable teams
 *
 */
class Teams {

	/**
	 * Create a new team on Signable
	 *
	 * @param string $teamName        required - the name of the new team
	 * @param array  $teamPermissions optional - an array of permissions to set as boolean true/false for the team as follows:
	 *                                           'team_permission_own'      - restrict this team to their own documents
	 *                                           'team_permission_users'    - restrict this team to manage users
	 *                                           'team_permission_branding' - restrict this team to manage branding
	 *                                           'team_permission_apps'     - restrict this team to manage apps
	 *                                           'team_permission_settings' - restrict this team to manage settings
	 *                                           'team_permission_company'  - restrict this team to manage company information, including billing details
	 *
	 * @return mixed                  API response
	 */
	public static function createNew( $teamName, $teamPermissions = array() ) {

		$data = array(
			'team_name'  => $teamName,
		);

		foreach ( $teamPermissions as $permissionType => $option ) {
			$data[$permissionType] = $option;
		}

		return ApiClient::call( 'teams', 'post', $data, new curlWrapper() );
	}

	/**
	 * Retrieve a single team from Signable
	 *
	 * @param  int $teamID required - the ID of the team to retrieve
	 *
	 * @return mixed        API response
	 */
	public static function getSingle( $teamID ) {

		return ApiClient::call( 'teams/' . $teamID, 'get', array(), new curlWrapper() );
	}

	/**
	 * Retrieve multiple teams from Signable
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

		return ApiClient::call( 'teams', 'get', $data, new curlWrapper() );
	}

	/**
	 * Update a team on Signable
	 *
	 * @param int    $teamID          required - the ID of the team to update
	 * @param string $teamName        required - the updated name of the team
	 * @param array  $teamPermissions optional - an array of permissions to update as boolean true/false for the team as follows:
	 *                                           'team_permission_own'      - restrict this team to their own documents
	 *                                           'team_permission_users'    - restrict this team to manage users
	 *                                           'team_permission_branding' - restrict this team to manage branding
	 *                                           'team_permission_apps'     - restrict this team to manage apps
	 *                                           'team_permission_settings' - restrict this team to manage settings
	 *                                           'team_permission_company'  - restrict this team to manage company information, including billing details
	 *
	 * @return mixed                  API response
	 */
	public static function update( $teamID, $teamName, $teamPermissions = array() ) {

		$data = array(
			'team_name'  => $teamName,
		);

		foreach ( $teamPermissions as $permissionType => $option ) {
			$data[$permissionType] = $option;
		}

		return ApiClient::call( 'teams/' . $teamID, 'put', $data, new curlWrapper() );
	}

	/**
	 * Delete a team on Signable
	 *
	 * @param  int $teamID required - the ID of the team to delete
	 *
	 * @return mixed          API response
	 */
	public static function delete( $teamID ) {

		return ApiClient::call( 'teams/' . $teamID, 'delete', array(), new curlWrapper() );
	}
}