<?php

/*
 * @copyright 2018 Hilmi Erdem KEREN
 * @license MIT
 */

namespace Erdemkeren\Validators\TrNatIdNumValidator;

/**
 * Class NviTcKimlikWebServiceRequest.
 */
final class TurkishNationalIdNumberValidator
{
    /**
     * The "T.C. İçişleri Bakanlığı Nüfus ve Vatandaşlık İşleri Genel Müdürlüğü"
     * Turkish National Identification Number validation service request.
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
     * @param NaturalizationRecord $naturalizationRecord
     *
     * @return bool
     */
    public function validate(NaturalizationRecord $naturalizationRecord): bool
    {
        $response = $this->nviTcKimlikWebServiceRequest->send($naturalizationRecord);

        return 'true' === $response;
    }
}
