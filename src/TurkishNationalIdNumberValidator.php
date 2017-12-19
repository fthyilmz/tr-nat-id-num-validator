<?php

namespace Erdemkeren\Validators\TrNatIdNumValidator;

/**
 * Class NviTcKimlikWebServiceRequest.
 */
final class TurkishNationalIdNumberValidator
{
    /**
     * The "T.C. İçişleri Bakanlığı Nüfus ve Vatandaşlık İşleri Genel Müdürlüğü"
     * national identification number validation service request.
     *
     * @var NviTcKimlikWebServiceRequest
     */
    private $nviTcKimlikWebServiceRequest;

    /**
     * TurkishNationalIdNumberValidator constructor.
     *
     * @param NviTcKimlikWebServiceRequest $nviTcKimlikWebServiceRequest
     */
    public function __construct(NviTcKimlikWebServiceRequest $nviTcKimlikWebServiceRequest)
    {
        $this->nviTcKimlikWebServiceRequest = $nviTcKimlikWebServiceRequest;
    }

    /**
     * Validate the national identification number using NVI services.
     *
     * @param  string $natIdNum
     * @param  string $firstName
     * @param  string $lastName
     * @param  string $birthYear
     *
     * @return bool
     */
    public function validate(string $natIdNum, string $firstName, string $lastName, string $birthYear): bool
    {
        try {
            $response = $this->nviTcKimlikWebServiceRequest->send(
                new NaturalizationRecord($natIdNum, $firstName, $lastName, $birthYear)
            );
        } catch (InvalidTurkishNationalIdentificationNumberException $e) {
            return false;
        }


        return (strip_tags($response) === 'true') ? true : false;
    }
}
