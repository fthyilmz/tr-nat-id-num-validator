<?php

/*
 * @copyright 2018 Hilmi Erdem KEREN
 * @license MIT
 */

namespace Erdemkeren\Validators\TrNatIdNumValidator\Test;

use PHPUnit\Framework\TestCase;
use Erdemkeren\Validators\TrNatIdNumValidator\NaturalizationRecord;
use Erdemkeren\Validators\TrNatIdNumValidator\NviTcKimlikWebServiceRequest;

/**
 * Class NviTcKimlikWebServiceRequestTest.
 *
 * @covers \Erdemkeren\Validators\TrNatIdNumValidator\NviTcKimlikWebServiceRequest
 */
class NviTcKimlikWebServiceRequestTest extends TestCase
{
    public function test_it_fetches_the_web_service_results(): void
    {
        $request = new NviTcKimlikWebServiceRequest();

        $response = $request->send(new NaturalizationRecord(
            '10000000146',
            'Gazi Mustafa Kemal',
            'Atatürk',
            '1881'
        ));

        $this->assertSame('false', $response);
    }
}
