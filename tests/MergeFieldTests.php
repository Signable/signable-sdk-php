<?php

namespace Signable;

class MergeFieldTests extends TestCase {

    /**
     * Test the created merge field returns as expected
     */
    public function testMergeField() {

        $mergeField = new MergeField( 10, 'value' );
        $this->assertEquals( 10, $mergeField->field_id );
        $this->assertEquals( 'value', $mergeField->field_value );
    }
}