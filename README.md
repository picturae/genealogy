[![Build Status](https://travis-ci.org/picturae/genealogy.svg?branch=master)](https://travis-ci.org/picturae/genealogy)
[![Coverage Status](https://coveralls.io/repos/picturae/genealogy/badge.svg?branch=master)](https://coveralls.io/r/picturae/genealogy?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/55dd7ac58d9c4b00180009d7/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55dd7ac58d9c4b00180009d7)

# Picturae webkitchen genealogy client #

## Introduction ##

The genealogy client library is released for third parties who want to integrate
a serverside fallback for the genealogy component.
This can be used to improve SEO ranking (or) and sharing on social networks as facebook, twitter
which do not support javascript.

Currently there is only a PHP implementation but it can serve as an example for 
implementation in other languages as Javascript / C# / Java etc.

## Installation ##

```
composer require picturae/genealogy
```

## Usage ##

See below the code example for the client

```php
$client = new \Picturae\Genealogy\Client('api-key');

// Get a deed
$deed = $client->getDeed($id);
$person = $client->getPerson($id);
$register = $client->getRegister($id);

// Get a result list of deeds
// all parameters are optional
$deed = $client->getDeeds([
    'q' => 'something', // search query
    'rows' => 100,      // amount of rows to return
    'page' => 1,        // page to return
    'facetFields' => [  // facet's to return
        'search_s_place'
    ],
    'fq' => [
        'search_s_place: "Amsterdam"' // apply filter query
    ],
    'sort' => 'search_s_place asc'   // sort result set (default by relevance)
]);

// Get a result list of registers
// all parameters are optional
$deed = $client->getRegisters([
    'q' => 'something', // search query
    'rows' => 100,      // amount of rows to return
    'page' => 1,        // page to return
    'facetFields' => [  // facet's to return
        'search_s_place'
    ],
    'fq' => [
        'search_s_place: "Amsterdam"' // apply filter query
    ],
    'sort' => 'search_s_place asc'   // sort result set (default by relevance)
]);

// Get a result list of persons
// all parameters are optional
$deed = $client->getPersons([
    'q' => 'something', // search query
    'rows' => 100,      // amount of rows to return
    'page' => 1,        // page to return
    'facetFields' => [  // facet's to return
        'search_s_place'
    ],
    'fq' => [
        'search_s_place: "Amsterdam"' // apply filter query
    ],
    'sort' => 'search_s_place asc'   // sort result set (default by relevance)
]);

```

### Serverside fallback ###

[Full example](examples/serverside-fallback)

```php
// If you do not provide a url the current url is used
$url = new \Picturae\Genealogy\URL();

// Check if we are on a permalink of a deed
if ($url->isDeedDetail()) {
    
    // Get the id for the deed from the URL
    $id = $url->getDeedUUID();

    // Instantiate the client with your API key
    $client = new \Picturae\Genealogy\Client('api-key');

    // Fetch the deed
    $deed = $client->getDeed($id);

    // Check if the deed is returned
    if (!empty($deed) {
        
        // Add your logic for the fallback
        // e.g add opengraph tags for facebook / twitter
        // or provide a html fallback

    }
}

```

### Sitemap ###

It's recommended to create a sitemap and submit it to google to improve crawling
In the examples folder is a demo how you could implement this.

[Full example](examples/sitemap)