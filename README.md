# PHP UnitTest Sqlite

This package optimizes unit testing speed, especially for packages with a large number of migrations and/or seeders.

The package works by managing two copies of a sqlite database, `base` and `copy`. Migrations and seeders are run onto `copy`.
`Copy` is cloned into `base`. Every unit test with `RefreshDatabase` trait will delete `copy` and clone `base` into `copy`.
`Base` is automatically deleted at the end of the unit test.

## Commands

```php artisan sqlite:delete```
Deletes the `base` file.

## PHP Unit

Add the following listener to phpunit.xml.

```
<listeners>
    <listener class="BrandonBest\UnittestSqlite\DatabaseTestListener"/>
</listeners>
```

## Future Plans

 # Keep the base file at the end of unit testing by default. Offer a config setting to turn this feature off.