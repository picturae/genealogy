![Build status](https://api.travis-ci.org/picturae/genealogy.svg?branch=master)

# Picturae webkitchen genealogy client #

## Installation ##

```
composer require picturae/genealogy
```

## Usage ##

```php
new \Picturae\Genealogy\Client('api-key');
```

### Serverside fallback ###

```php

$url = new \Picturae\Genealogy\URL();
if ($url->isDeedDetail()) {
    $id = $url->getDeedUUID();
    $client = new \Picturae\Genealogy\Client('api-key');
    $deed = $client->getDeed($id);
}

```
