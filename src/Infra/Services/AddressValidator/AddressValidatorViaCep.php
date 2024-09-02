<?php

namespace Jhonattan\BaseProjectFromEcommerce\Infra\Services\AddressValidator;

use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\AddressValidator;

class AddressValidatorViaCep implements AddressValidator
{
    public function validate(string $zipCode): bool
    {
        $this->requestViaCep($zipCode);
        return true;
    }
    private function requestViaCep(string $zipCode): void
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://viacep.com.br/ws/{$zipCode}/json/");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);
        $responseInArray = json_decode($response, true);
        $this->verifyRequestIsValid($responseInArray);
    }
    private function verifyRequestIsValid(array $response)
    {
        if (empty($response)) {
            throw new \Exception("Zip code not found.");
        }
        if (isset($response['erro']) && $response['erro'] === 'true') {
            throw new \Exception("error in request");
        }
    }
}
