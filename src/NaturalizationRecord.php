<?php

/*
 * @copyright 2018 Hilmi Erdem KEREN
 * @license MIT
 */

namespace Erdemkeren\Validators\TrNatIdNumValidator;

/**
 * Class NaturalizationRecord.
 */
final class NaturalizationRecord
{
    /**
     * The turkish-letter filter pattern.
     *
     * @var string
     */
    private static $letterFilterPattern = '/[^a-zA-Z\sŞşİıĞğÜüÖöÇç.]/';

    /**
     * The number filter pattern.
     *
     * @var string
     */
    private static $numberFilterPattern = '/[^0-9]/';

    /**
     * The valid national identification number pattern.
     *
     * @var string
     */
    private static $trNationalIdNumberPattern = '/^[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}$/';

    /**
     * The national identification number.
     *
     * @var string
     */
    private $natIdNum;

    /**
     * The first name.
     *
     * @var string
     */
    private $firstName;

    /**
     * The last name.
     *
     * @var string
     */
    private $lastName;

    /**
     * The birth year.
     *
     * @var int
     */
    private $birthYear;

    /**
     * NaturalizationRecord constructor.
     *
     * @param string $natIdNum
     * @param string $firstName
     * @param string $lastName
     * @param int    $birthYear
     */
    public function __construct(string $natIdNum, string $firstName, string $lastName, int $birthYear)
    {
        $this->lastName = self::tr_strtoupper(preg_replace(self::$letterFilterPattern, '', $lastName));
        $this->firstName = self::tr_strtoupper(preg_replace(self::$letterFilterPattern, '', $firstName));
        $this->birthYear = (int) preg_replace(self::$numberFilterPattern, '', (string) $birthYear);
        $this->natIdNum = preg_replace(self::$numberFilterPattern, '', $natIdNum);

        $natIdNum = $this->natIdNum();
        $isPatternValid = $this->validatePattern($natIdNum);
        $isAlgorithmValid = $this->validateAlgorithm($natIdNum) || $this->validateUsingAlternativeAlgorithm($natIdNum);

        if (! ($isPatternValid && $isAlgorithmValid)) {
            $this->throwValidationException('The given national identification number is invalid.');
        }
    }

    /**
     * Get the national identification number.
     *
     * @return string
     */
    public function natIdNum(): string
    {
        return $this->natIdNum;
    }

    /**
     * Get the first name.
     *
     * @return string
     */
    public function firstName(): string
    {
        return $this->firstName;
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastName;
    }

    /**
     * Get the birth year.
     *
     * @return int
     */
    public function birthYear(): int
    {
        return $this->birthYear;
    }

    /**
     * Validate the pattern of the given national identification number.
     *
     * @param string $natIdNum
     *
     * @return bool
     */
    private function validatePattern(string $natIdNum): bool
    {
        return preg_match(self::$trNationalIdNumberPattern, $natIdNum) ? true : false;
    }

    /**
     * Validate the given national identification number algorithmically.
     *
     * @param string $id
     *
     * @return bool
     */
    private function validateAlgorithm(string $id): bool
    {
        $sumOfOdds = $id[0] + $id[2] + $id[4] + $id[6] + $id[8];
        $sumOfEvens = $id[1] + $id[3] + $id[5] + $id[7];

        $controlDigitOne = (int) $id[9];
        $controlDigitTwo = (int) $id[10];
        $testVariableOne = (int) ($sumOfOdds * 7 - $sumOfEvens) % 10;
        $testVariableTwo = (int) ($sumOfOdds + $sumOfEvens + $controlDigitOne) % 10;

        if (($testVariableOne !== $controlDigitOne) || ($testVariableTwo !== $controlDigitTwo)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the given national identification using the alternative algorithm.
     *
     * @param string $id
     *
     * @return bool
     */
    private function validateUsingAlternativeAlgorithm(string $id): bool
    {
        $sumOfOdds = $id[0] + $id[2] + $id[4] + $id[6] + $id[8];
        $sumOfFirstTenDigits = (
            $id[0] + $id[1] + $id[2] + $id[3] + $id[4] +
            $id[5] + $id[6] + $id[7] + $id[8] + $id[9]
        );

        if ($sumOfFirstTenDigits % 10 !== (int) $id[10]) {
            return false;
        }

        if (($sumOfOdds * 8) % 10 !== (int) $id[10]) {
            return false;
        }

        return true;
    }

    /**
     * Throws an invalid Turkish National Identification Number exception with the given message.
     *
     * @param string $message
     */
    private function throwValidationException(string $message): void
    {
        throw new InvalidTurkishNationalIdentificationNumberException($message);
    }

    /**
     * The turkish str to upper function which works right.
     *
     * @param string $str
     *
     * @return string
     */
    private static function tr_strtoupper(string $str): string
    {
        return strtoupper(str_replace(['ç', 'i', 'ı', 'ğ', 'ö', 'ş', 'ü'], ['Ç', 'İ', 'I', 'Ğ', 'Ö', 'Ş', 'Ü'], $str));
    }
}
