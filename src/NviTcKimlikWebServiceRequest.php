<?php

namespace Erdemkeren\Validators\TrNatIdNumValidator;

/**
 * Class NviTcKimlikWebServiceRequest.
 */
final class NviTcKimlikWebServiceRequest
{
    /**
     * The payload of the request.
     *
     * @var string
     */
    private static $payload = "<?xml version='1.0' encoding='utf-8'?>
		<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>
			<soap:Body>
				<TCKimlikNoDogrula xmlns='http://tckimlik.nvi.gov.tr/WS'>
					<TCKimlikNo>%u</TCKimlikNo>
					<Ad>%s</Ad>
					<Soyad>%s</Soyad>
					<DogumYili>%u</DogumYili>
				</TCKimlikNoDogrula>
			</soap:Body>
		</soap:Envelope>";

    /**
     * Send the request with the given parameters.
     *
     * @param  NaturalizationRecord $naturalizationRecord
     *
     * @return string
     */
    public function send(NaturalizationRecord $naturalizationRecord): string
    {
        $ch = curl_init();
        $body = $this->makeBody(
            $naturalizationRecord->natIdNum(),
            $naturalizationRecord->firstName(),
            $naturalizationRecord->lastName(),
            $naturalizationRecord->birthYear()
        );

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                'POST /Service/KPSPublic.asmx HTTP/1.1',
                'Host: tckimlik.nvi.gov.tr',
                'Content-Type: text/xml; charset=utf-8',
                'SOAPAction: "http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula"',
                'Content-Length: '.strlen($body),
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return strip_tags($response);
    }

    /**
     * Make the request body with the constructor parameters.
     *
     * @param  string $natIdNum
     * @param  string $firstName
     * @param  string $lastName
     * @param  int    $birthYear
     *
     * @return string
     */
    private function makeBody(string $natIdNum, string $firstName, string $lastName, int $birthYear): string
    {
        return sprintf(self::$payload, $natIdNum, $firstName, $lastName, $birthYear);
    }
}