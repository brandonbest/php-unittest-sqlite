# PHP UnitTest Sqlite

This package optimizes unit testing speed, especially for packages with a large number of migrations and/or seeders.

The package works by managing two copies of a sqlite database, `base` and `copy`. Migrations and seeders are run on `copy` if `base` does not exist.
`Copy` is cloned into `base`. Every unit test with `RefreshDatabase` trait will delete `copy` and clone `base` into `copy`.

`Base` is deleted at the end of the unit test (you can keep `Base` around with a simple configuration update).

---

# Setup

## Install

```
composer require --dev brandonbest/php-unittest-sqlite
```

## PHP Unit

Add the following listener to phpunit.xml.

```
<listeners>
    <listener class="BrandonBest\UnittestSqlite\DatabaseTestListener"/>
</listeners>
```

## Commands

```php artisan sqlite:delete```
Deletes the `base` file.

## Future Plans

 - Automatically detect new migrations and update the base sqlite
