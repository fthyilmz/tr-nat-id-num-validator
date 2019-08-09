<?php

/*
 * @copyright 2018 Hilmi Erdem KEREN
 * @license MIT
 */

namespace Erdemkeren\Validators\TrNatIdNumValidator\Test;

use PHPUnit\Framework\TestCase;
use Erdemkeren\Validators\TrNatIdNumValidator\NaturalizationRecord;
use Erdemkeren\Validators\TrNatIdNumValidator\InvalidTurkishNationalIdentificationNumberException;

/**
 * Class NaturalizationRecordTest.
 *
 * @covers \Erdemkeren\Validators\TrNatIdNumValidator\NaturalizationRecord
 */
class NaturalizationRecordTest extends TestCase
{
    public function test_it_can_be_instantiated(): void
    {
        $naturalizationRecord = new NaturalizationRecord(
            '10000000146',
            'Gazi Mustafa Kemal',
            'Atatürk',
            '1881'
        );

        $this->assertInstanceOf(NaturalizationRecord::class, $naturalizationRecord);
    }

    public function test_it_enforces_valid_turkish_national_identification_number_pattern(): void
    {
        $this->expectException(InvalidTurkishNationalIdentificationNumberException::class);

        new NaturalizationRecord(
            '10000000148',
            'Gazi Mustafa Kemal',
            'Atatürk',
            '1881'
        );
    }

    public function test_it_provides_the_data_provided_on_initiation(): void
    {
        $naturalizationRecord = new NaturalizationRecord(
            $natIdNum = '10000000146',
            'Gazi Mustafa Kemal',
            'Atatürk',
            $birthYear = 1881
        );

        $this->assertSame($natIdNum, $naturalizationRecord->natIdNum());
        $this->assertSame('GAZİ MUSTAFA KEMAL', $naturalizationRecord->firstName());
        $this->assertSame('ATATÜRK', $naturalizationRecord->lastName());
        $this->assertSame($birthYear, $naturalizationRecord->birthYear());
    }

    public function test_it_accepts_nouns_with_carets(): void
    {
        $this->expectException(InvalidTurkishNationalIdentificationNumberException::class);

        $nr = new NaturalizationRecord(
            '10000000148',
            'Hilâl',
            'Hilâl',
            '1990'
        );

        $this->assertSame('HİLÂL', $nr->firstName());
        $this->assertSame('HİLÂL', $nr->lastName());
    }

    public function test_it_must_be_11_characters(): void
    {
        $this->expectException(InvalidTurkishNationalIdentificationNumberException::class);

        new NaturalizationRecord(
            '',
            'Gazi Mustafa Kemal',
            'Atatürk',
            '1881'
        );
    }
}
