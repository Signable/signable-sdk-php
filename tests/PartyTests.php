<?php

namespace Signable;

class PartyTests extends TestCase {

    /**
     * Test the created party returns as expected
     */
    public function testParty() {

        $party = new Party( 'New Party', 'new@party.email', 10, 'New Message' );
        $this->assertEquals( 'New Party', $party->party_name );
        $this->assertEquals( 10, $party->party_id );
        $this->assertNull( $party->party_role );
        $this->assertEquals( 'new@party.email', $party->party_email );
        $this->assertEquals( 'New Message', $party->party_message );

        $party = new Party( 'New Party', 'new@party.email', 'role', 'New Message', 'no' );
        $this->assertEquals( 'role', $party->party_role );
        $this->assertNull( $party->party_id );
    }
}