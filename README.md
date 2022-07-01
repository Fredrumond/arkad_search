# Arkad Search

## Standards

PHP - [PSR-12](https://www.php-fig.org/psr/psr-12/)

## Setup

Add to your composer.json:

**require**: _"Fredrumond/arkad_search" : "^0.1.0"_

**repositories**: _[{"type":"vcs","url":"https://https://github.com/Fredrumond/arkad_search"}]_

Now run **composer update Fredrumond/arkad_search**

## Usage classes

```php
use Fredrumond\ArkadCrawler\Service\ArkadCrawlerService;

$config = [
    "codes" => [
        "acoes" => [
            "itub3","sapr4"
        ],
        "fundos" => [
            "hsml11"
        ]
    ]
];

$service = new ArkadCrawlerService($config);
var_dump($service->search());
```