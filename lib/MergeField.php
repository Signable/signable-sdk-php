<?php

namespace Signable;

/**
 * This class makes it easy for the user to create Signable merge fields (used for creating envelopes)
 *
 */
class MergeField {

    public $field_id;
    public $field_value;

    /**
     * Create the merge field object using the parameters provided
     *
     * @param int    $fieldID    An integer representing the ID of the merge field
     * @param string $fieldValue A string representing the value of the merge field
     */
    public function __construct( $fieldID, $fieldValue ) {

        $this->field_id    = $fieldID;
        $this->field_value = $fieldValue;
    }
}