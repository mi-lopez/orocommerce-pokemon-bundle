[![Version](http://poser.pugx.org/mi-lopez/orocommerce-pokemon-bundle/v)](https://packagist.org/packages/mi-lopez/orocommerce-pokemon-bundle)
[![Total Downloads](http://poser.pugx.org/mi-lopez/orocommerce-pokemon-bundle/downloads)](https://packagist.org/packages/mi-lopez/orocommerce-pokemon-bundle)

# Oro Commerce Pokemon Bundle
Code used as an example for oro tech 7 using the oro integration package and the pokemon API https://pokeapi.co/

## Features
* CRUD of a Pokemon entity with name, code, image and type
* Fetch list of pokemons through Oro Integrations
* Command to get the images and types using an Oro Integration Transport
## Requirements

| | Version |
| :--- |:--------|
| PHP  | 8.2     |
| OroCommerce | 5.1.*   |

## Installation

1. Install the Plugin using Composer:
```shell
composer require mi-lopez/orocommerce-pokemon-bundle
```
2. Run the Migrations
```shell
bin/console oro:migration:load --force
```
3. Clear Cache
```shell
bin/console cache:clear
```
4. Install & Build the Assets
```shell
bin/console oro:assets:install --symlink
```
