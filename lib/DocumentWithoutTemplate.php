<?php

namespace Signable;

/**
 * This class makes it easy for the user to create Signable documents (used for creating envelopes)
 *
 */
class DocumentWithoutTemplate {

    public $document_title;
    public $document_url;
    public $document_file_content;
    public $document_file_name;

    /**
     * Create the document object using the parameters provided
     *
     * Note: when creating without a template either documentURL or both documentFileContent and documentFileName are required
     *
     * @param string $documentTitle       required - the string of the title of the document
     * @param string $documentURL         required - the url of the title of the document
     * @param string $documentFileContent optional - a base64 encoded string of the contents of a PDF or Word document
     * @param string $documentFileName    required - the string of the filename of the document, including the extension
     */
    public function __construct( $documentTitle, $documentURL = '', $documentFileContent = '', $documentFileName = '' ) {

        $this->document_title = $documentTitle;

        if ( '' !== $documentURL ) {
            $this->document_url = $documentURL;
        }

        if ( '' !== $documentFileContent ) {
            $this->document_file_content = $documentFileContent;
        }

        if ( '' !== $documentFileName ) {
            $this->document_file_name = $documentFileName;
        }
    }
}