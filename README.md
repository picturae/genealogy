![Build status](https://api.travis-ci.org/picturae/genealogy.svg?branch=master)

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

```php
new \Picturae\Genealogy\Client('api-key');
```

### Serverside fallback ###

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
