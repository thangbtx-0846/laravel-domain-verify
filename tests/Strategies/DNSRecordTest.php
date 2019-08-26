<?php

namespace SunAsterisk\DomainVerifier\Tests\Strategies;

use PHPUnit\Framework\TestCase;
use SunAsterisk\DomainVerifier\Strategies\DNSRecord;
use SunAsterisk\DomainVerifier\Contracts\Models\DomainVerifiableInterface;
use Mockery as m;

class DNSRecordTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->verification = new \stdClass();
        $this->verification->token = 'abc';
        $this->url = 'https://viblo.asia';
    }

    public function test_it_can_verify_txt_record()
    {
        $domainVerifiable = m::mock(DomainVerifiableInterface::class);
        /** Mock facade */
        m::mock('alias:\SunAsterisk\DomainVerifier\DomainVerificationFacade')
            ->shouldReceive('getTokenFor')
            ->andReturn($this->verification);
        /** @var DNSRecord|m\MockInterface $strategy */
        $strategy = m::mock(DNSRecord::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $result = $strategy->verify($this->url, $domainVerifiable);

        $this->assertTrue($result);
    }

    public function testGetTxtRecords()
    {
    	$dns = m::mock(DNSRecord::class);
        $txtRecords = $dns->getTxtRecords($this->url);

        $this->assertTrue(isset($txtRecords));
	}

    public function testGeTokenRecord()
    {
    	$dns = m::mock(DNSRecord::class);
        $txtRecords = $dns->getTxtRecords($this->url);;
        $tokenRecords = $dns->getTokenRecords($txtRecords);

        $this->assertTrue(isset($tokenRecords));
    }
}
