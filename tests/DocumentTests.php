<?php

namespace Signable;

class DocumentTests extends TestCase {

    /**
     * Test the created document returns as expected when using a template
     */
    public function testDocumentWithTemplate() {

        $document = new DocumentWithTemplate( 'Test Document', 'fingerprint' );
        $this->assertEquals( 'Test Document', $document->document_title );
        $this->assertEquals( 'fingerprint', $document->document_template_fingerprint );
        $this->assertNull( $document->document_merge_fields );

        $document = new DocumentWithTemplate( 'Test Document', 'fingerprint', new \stdClass() );
        $this->assertNull( $document->document_merge_fields );

        $document = new DocumentWithTemplate( 'Test Document', 'fingerprint', array( 'merge_field' => 'merge1' ) );
        $this->assertEquals( array( 'merge_field' => 'merge1' ), $document->document_merge_fields );
    }

    /**
     * Test the created document returns as expected when not using a template
     */
    public function testDocumentWithoutTemplate() {

        $document = new DocumentWithoutTemplate( 'Test Document', 'url' );
        $this->assertEquals( 'Test Document', $document->document_title );
        $this->assertEquals( 'url', $document->document_url );
        $this->assertNull( $document->document_file_content );
        $this->assertNull( $document->document_file_name );

        $document = new DocumentWithoutTemplate( 'Test Document', '', 'content', 'name' );
        $this->assertNull( $document->document_url );
        $this->assertEquals( 'content', $document->document_file_content );
        $this->assertEquals( 'name', $document->document_file_name );

        $document = new DocumentWithoutTemplate( 'Test Document' );
        $this->assertNull( $document->document_url );
        $this->assertNull( $document->document_file_content );
        $this->assertNull( $document->document_file_name );
    }
}