# dfkgw/mime-fold-flowed-text

## Requirement

You need [Composer](https://getcomposer.org/) installed globally, or you can
download composer.phar into your PHP project.

## Install

If you have Composer globally installed,
```
$ composer require dfkgw/mime-fold-flowed-text
```
or
```
$ php composer.phar require dfkgw/mime-fold-flowed-text
```

## Development

```
$ git clone https://tiramis2.doshisha.ac.jp/gogs/daiji/MIME-Fold-Flowed-Text.git
$ cd MIME-Fold-Flowed-Text
$ composer install
```

## Test/lint

Unit test (PHPUnit)
```
$ ./vendor/bin/phpunit
```

PHP Mess detector
```
$ ./vendor/bin/phpmd src/*.php text unusedcode,codesize,naming
```

PHP Coding Standards Fixer
```
$ ./vendor/bin/php-cs-fixer fix src/*.php --dry-run -v --diff
```

