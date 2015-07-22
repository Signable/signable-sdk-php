<?php

namespace Signable;

/**
 * This class makes it easy for the user to create Signable parties (used for creating envelopes)
 *
 */
class Party {

    public $party_name;
    public $party_email;
    public $party_id;
    public $party_role;
    public $party_message;

    /**
     * Create the party object using the parameters provided
     *
     * If no template id used party ID is not required and a role must be provided instead
     *
     * @param string $partyName    A string of the name of the signing party
     * @param string $partyEmail   A string of a valid email address of the party
     * @param int    $partyID      An integer representing the ID of the party which is setup in the template that you want to send out.
     * @param string $partyMessage A message which will be sent to this party when it is their turn to sign. It is shown in the email that is sent to the signing party.
     * @param string $haveTemplate 'yes' or 'no' dependant on whether a template is being used
     */
    public function __construct( $partyName, $partyEmail, $partyID, $partyMessage = '',  $haveTemplate = 'yes' ) {

        $this->party_name    = $partyName;
        $this->party_email   = $partyEmail;
        $this->party_message = $partyMessage;

        if ( 'yes' == $haveTemplate ) {
            $this->party_id   = $partyID;
        } else {
            $this->party_role = $partyID;
        }
    }
}