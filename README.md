# virustotal-api
A simple wrapper for virustotal.com service, without any external dependencies, pure PHP.


## Example with file upload

Get your free Api key, signing here
https://www.virustotal.com/gui/sign-in

```php

use Virustotal\Dto\UploadFileDto;
use Virustotal\Service\VirustotalService;

$apiKey = "please_set_your_api_key";  // Change this value with your API KEY

$vts = new VirustotalService($apiKey);
$ufdto = $vts->uploadFile("/tmp/vt.txt");
$faDto = $vts->analyze($ufdto);
if ($faDto->getMalicious() === 0 && $faDto->getSuspicious() === 0) {
    echo PHP_EOL . "No virus detected" . PHP_EOL;
}
```

## Example with url

```php

use Virustotal\Dto\UploadFileDto;
use Virustotal\Service\VirustotalService;

$apiKey = "please_set_your_api_key";  // Change this value with your API KEY

$vts = new VirustotalService($apiKey);
$ufdto = $vts->scanUrl($url);
$faDto = $vts->analyze($ufdto);
if ($faDto->getMalicious() === 0 && $faDto->getSuspicious() === 0) {
    echo PHP_EOL . "No virus detected" . PHP_EOL;
}
```
