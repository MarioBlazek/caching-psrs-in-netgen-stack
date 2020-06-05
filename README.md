# PSR-6 and PSR-16 in Netgen stack

## Description

### PSR-6

For more info about PSR-6 please visit this [link](https://www.php-fig.org/psr/psr-6/).

### PSR-16

For more info about PSR-16 please visit this [link](https://www.php-fig.org/psr/psr-16/).

### Symfony and PSR's

Symfony implement caching PSR's through the [Cache component](https://symfony.com/doc/current/components/cache.html). PSR-16 standard is supported via [adapters](https://symfony.com/doc/current/components/cache/psr6_psr16_adapters.html).

### Redis

1. Include `cache.redis.yml` configuration from `cache_pool`
2. Replace `cache.app` with `cache.redis` in your service arguments
3. Start local Redis server with:

```bash
redis-server /usr/local/etc/redis.conf
```

4. Test

#### Redis commands

Use `redis-cli` to enter the Redis server through command line.

Once you are inside the Redis you can use this commands: 

* `keys *` - to list all the available keys
* `ttl key` - to display the time required for key to expire
* `expire key 0` - explicitly expire the key
* `del key` - delete the key from Redis

## Install guide

To install this example do the following:
* clone this repository
* run `composer install`
* create database `php bin/console doctrine:database:create`
* install demo content `php bin/console ezplatform:install netgen-media`
* install frontend dependecies `yarn install`
* build dev assets `yarn build:dev`
* run `symfony serve` to start Symfony server

## Presentation

Presentation is available in PDF format and can be accessed [here](PSR-6_and_PRS-16_caching.pdf).
