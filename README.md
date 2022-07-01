# Arkad Search

## Standards

PHP - [PSR-12](https://www.php-fig.org/psr/psr-12/)

## Setup

Add to your composer.json:

**require**: _"fredrumond/arkad-crawler" : "^1.0.0"_

**repositories**: _[{"type":"vcs","url":"https://github.com/Fredrumond/arkad_search"}]_

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