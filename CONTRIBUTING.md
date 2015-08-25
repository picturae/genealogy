# Contributing to the genealogy client

:+1::tada: First off, thanks for taking the time to contribute! :tada::+1:

The project uses [git flow](http://danielkummer.github.io/git-flow-cheatsheet/) for versioning 
and uses [psr-2 code guidelines](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

```
composer install --dev

phpunit
./vendor/bin/phpcs --standard=psr2 ./src
./vendor/bin/phpmd ./src/ text ./vendor/phpmd/phpmd/src/main/resources/rulesets/cleancode.xml
```