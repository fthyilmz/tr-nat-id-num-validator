<?php

namespace Erdemkeren\Validators\TrNatIdNumValidator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

/**
 * Class TurkishNationalIdNumberValidationServiceProvider.
 */
final class TrNatIdNumValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Validator::extend('tr_nat_id_num', function (string $attribute, string $value, array $parameters) {
            $validator = new TurkishNationalIdNumberValidator(new NviTcKimlikWebServiceRequest());

            return $validator->validate($value, ...$parameters);
        });

        Validator::replacer('tr_nat_id_num', function ($message, $attribute, $rule, $parameters) {
            if ($message === 'validation.tr_nat_id_num') {
                return 'Belirtilen T.C. Kimlik Numarası doğrulanamadı.';
            }

            return $message;
        });
    }
}
