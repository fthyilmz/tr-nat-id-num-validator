# T.C. Kimlik Numarası Doğrulayıcı (Turkish National Identification Number Validator)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/114738239/shield?branch=master)](https://styleci.io/repos/114738239)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/erdemkeren/tr-nat-id-num-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/erdemkeren/tr-nat-id-num-validator/?branch=master)

Bu paket, Laravel 5.3+ uygulamalara TC Kimlik Numarası Doğrulaması özelliği ekler. 

## İçerik

- [Kurulum](#kurulum)
- [Kullanım](#kullanım)
    - [Validator Olarak Kullanımı](#validator-olarak-kullanımı)
    - [Özel Olarak Kullanımı](#ozel-olarak-kullanımı)
    - [Hata Mesajını Özelleştirmek](#hata-mesajını-ozellestirmek)
- [Değişiklik Listesi](#degisiklik-listesi)
- [Test](#test)
- [Güvenlik](#guvenlik)
- [Katkıda Bulunun](#katkıda-bulunun)
- [Tanıtımlar](#tanıtımlar)
- [Lisans](#lisans)

## Kurulum

Paketi composer üzerinden yükleyebilirsiniz:

```
composer require erdemkeren/tr-nat-id-num-validator
````

Eğer uygulamanızda otomatik keşif özelliği yoksa; 
ardından `config/app.php` dosyanıza servis sağlayıcımızı eklemelisiniz.

```php
...
'providers' => [
    ...
    Erdemkeren\Validators\TrNatIdNumValidator\TrNatIdNumValidationServiceProvider::class,
],
...
```

## Kullanım

### Validator Olarak Kullanımı

Paket kurulumunu tamamladıktan sonra; herhangi bir doğrulama kullanır gibi kullanabilirsiniz.

NVI'nin soap isteğinin gerçekleştirilebilmesi için; TC Kimlik Numarası ile birlikte sırası ile
kullanıcının adını, soyadını ve doğum yılını da vermeniz gerekmektedir.

```php
<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
class ExampleController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'tr_nat_id_num' => 'required|tr_nat_id_num:Hilmi Erdem,Keren,1990'
        ]);
 
        return "Hello!";
    }
}
```

### Ozel Olarak Kullanımı

Bu paket, sahnenin arkasında `TurkishNationalIdNumberValidator` sınıfını kullanır.
Eğer validation rule değil, özel bir kullanım ihtiyacınız varsa; siz de aynı sınıfı kullanabilirsiniz. 

```php
$validator = new TurkishNationalIdNumberValidator(new NviTcKimlikWebServiceRequest());

$result = $validator->validate($trNatIdNum, $name, $surname, $birthYear);
```

### Hata Mesajını Ozellestirmek

Verilen hata mesajını değiştirmek isterseniz 
`resources/lang/{dil}/validation.php`
dosyalarına istediğiniz hata mesajını ekleyebilirsiniz:

```php
'tr_nat_id_num' => "Vermek istediğiniz hata mesajı"
```

## Degisiklik Listesi

Lütfen son değişiklikleri görmek için [Değişiklik Listesi](CHANGELOG.md) dosyasını ziyaret ediniz.

## Test

Uygulama testleri henüz yazılmadı. phpunit kullanılarak yazılacak.

Testler hazırlandığında aşağıdaki şekilde çalıştırılabilir olacaktır:

``` bash
$ composer test
```

## Güvenlik

Uygulama, NVI tarafından sağlanan soap isteği şemasını kullanarak; 
yine NVI tarafından sağlanan bağlantı üzerinden doğrulama isteğinde bulunmaktadır.

Eğer yalnızca iç ağ üzerinde çalışan indoor bir uygulama geliştiriyorsanız; bu paket size uygun değildir.

## Katkıda Bulunun

Eğer katkıda bulunmak isterseniz lütfen [Katkıda Bulunun](CONTRIBUTING.md) dosyasını inceleyin.

## Tanıtımlar

- [Hilmi Erdem KEREN](https://github.com/erdemkeren)
- [Uğur Aydogdu](https://github.com/jnbn)

Bu paket

[epigra/tckimlik](https://github.com/epigra/tckimlik) paketinin üzerine geliştirilmiştir.

## Lisans

The MIT License (MIT). Detaylar için lütfen [Lisans Dosyasını](LICENSE.md) inceleyin.
