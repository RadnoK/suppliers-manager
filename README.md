# SupplierManager
A sample project with some fancy techniques and libraries.

## Setup
```bash
$ docker-compose up
$ docker exec -it app_php /bin/bash
```

## Usage
```
$ php bin/console app:create:supplier NAME
$ php bin/console app:supplier:synchronize NAME
```

As a name, you can pass one of the values below:
* `first`
* `second`
* `third`

Other values will cause a nice looking error :)

## Tests
```bash
$ composer check
$ composer test
```
