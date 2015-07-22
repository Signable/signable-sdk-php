<?php

namespace Signable;

/**
 * This class makes it easy for the user to create Signable documents (used for creating envelopes)
 *
 */
class DocumentWithTemplate {

    public $document_title;
    public $document_template_fingerprint;
    public $document_merge_fields;

    /**
     * Create the document object using the parameters provided
     *
     * @param string $documentTitle               required                - the string of the title of the document
     * @param string $documentTemplateFingerprint required (template)     - a valid fingerprint of the template you want to send out
     * @param array  $documentMergeFields         optional (template)     - an array of objects containing the following in each object:
     *                                             - field_id (required)    an integer representing the ID of the merge field
     *                                             - field_value (required) a string representing the value of the merge field
     */
    public function __construct( $documentTitle, $documentTemplateFingerprint, $documentMergeFields = array() ) {

        $this->document_title                = $documentTitle;
        $this->document_template_fingerprint = $documentTemplateFingerprint;

        if ( array() !== $documentMergeFields && is_array( $documentMergeFields ) ) {
            $this->document_merge_fields = $documentMergeFields;
        }
    }
}