# Picturae webkitchen genealogy sitemap #

## Introduction ##

It's recommended to create a sitemap for the webkitchen genealogy applicaiton
this example serves as a demo how to implement this.

## Installation ##

Install all dependencies and generate autoload

```
cd examples/sitemap
composer install
```

Run the server

```
php -S localhost:8080
```

Now point your browser to localhost:8080 and you should see the demo

## Permalinks ##

The sitemap works based on permalinks, which for deeds look like below:

http://example.com/optional-subdir/deeds/{uuid}