<?php
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
     *
     * @return void
     */
    public function boot(): void
    {
        Validator::extend('tr_national_id_number', function (string $attribute, string $value, array $parameters) {
            $validator = new TurkishNationalIdNumberValidator(new NviTcKimlikWebServiceRequest());

            return $validator->validate($value, ...$parameters);
        });
    }
}
