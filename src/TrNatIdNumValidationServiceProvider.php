<?php

/*
 * @copyright 2018 Hilmi Erdem KEREN
 * @license MIT
 */

namespace Erdemkeren\Validators\TrNatIdNumValidator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

/**
 * Class TurkishNationalIdNumberValidationServiceProvider.
 */
final class TrNatIdNumValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        Validator::extend('tr_nat_id_num', function (string $attribute, string $value, array $parameters) {
            $validator = new TurkishNationalIdNumberValidator(new NviTcKimlikWebServiceRequest());

            try {
                $naturalizationRecord = new NaturalizationRecord($value, ...$parameters);
            } catch (InvalidTurkishNationalIdentificationNumberException $e) {
                return false;
            }

            return $validator->validate($naturalizationRecord);
        });

        Validator::replacer('tr_nat_id_num', function ($message) {
            if ('validation.tr_nat_id_num' === $message) {
                return 'Belirtilen T.C. Kimlik Numarası doğrulanamadı.';
            }

            return $message;
        });
    }
}
