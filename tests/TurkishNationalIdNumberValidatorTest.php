<?php

/*
 * @copyright 2018 Hilmi Erdem KEREN
 * @license MIT
 */

namespace Erdemkeren\Validators\TrNatIdNumValidator\Test;

use PHPUnit\Framework\TestCase;
use Erdemkeren\Validators\TrNatIdNumValidator\NaturalizationRecord;
use Erdemkeren\Validators\TrNatIdNumValidator\NviTcKimlikWebServiceRequest;
use Erdemkeren\Validators\TrNatIdNumValidator\TurkishNationalIdNumberValidator;

/**
 * Class TurkishNationalIdNumberValidatorTest.
 *
 * @covers \Erdemkeren\Validators\TrNatIdNumValidator\TurkishNationalIdNumberValidator
 */
class TurkishNationalIdNumberValidatorTest extends TestCase
{
    /**
     * @var TurkishNationalIdNumberValidator
     */
    private $validator;

    /**
     * @var NaturalizationRecord
     */
    private $naturalizationRecord;

    public function setUp(): void
    {
        parent::setUp();

        $nviTcKimlikWebServiceRequest = new NviTcKimlikWebServiceRequest();

        $validator = new TurkishNationalIdNumberValidator($nviTcKimlikWebServiceRequest);
        $this->naturalizationRecord = new NaturalizationRecord(
            '10000000146',
            'Gazi Mustafa Kemal',
            'Atatürk',
            '1881'
        );

        $this->assertInstanceOf(TurkishNationalIdNumberValidator::class, $validator);

        $this->validator = $validator;
    }

    public function test_it_validates_the_given_naturalization_record(): void
    {
        $response = $this->validator->validate($this->naturalizationRecord);

        $this->assertFalse($response);
    }
}
