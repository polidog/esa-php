# esa-php

[![Build Status](https://travis-ci.org/polidog/esa-php.svg)](https://travis-ci.org/polidog/esa-php)
[![Coverage Status](https://coveralls.io/repos/polidog/esa-php/badge.svg)](https://coveralls.io/r/polidog/esa-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/polidog/esa-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/polidog/esa-php/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/polidog/esa-php/v/stable)](https://packagist.org/packages/polidog/esa-php)
[![Total Downloads](https://poser.pugx.org/polidog/esa-php/downloads)](https://packagist.org/packages/polidog/esa-php)
[![License](https://poser.pugx.org/polidog/esa-php/license)](https://packagist.org/packages/polidog/esa-php)

esa API v1 client library, written in PHP

## Installation

The recommended way to install esa-php is through Composer.

```
# Install Composer
curl -sS https://getcomposer.org/installer | php
```
Next, run the Composer command to install the lasted stable version of esa-php.

```
composer.phar install polidog/esa-php
```

## Usage

```
<?php

require 'vendor/autoload.php';

$client = new Polidog\Esa\Client("<access_token>", "foobar");

$client->teams();
// GET /v1/teams

$client->team('bar');
// GET /v1/teams/bar

$client->posts();
// GET /v1/teams/foobar/posts

$client->posts(["q" => "in:help"]);
// GET /v1/teams/foobar/posts?q=in%3Ahelp

$client->createPost(["name" => "foo"]);
// POST /v1/teams/foobar/posts

$client->updatePost(1, ["name" => "bar"]);
// PATCH /v1/teams/foobar/posts/1

$client->deletePost(1);
// DELETE /v1/teams/foobar/posts/1
```

## Contributing

1. Fork it ( https://github.com/polidog/esa-php/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request

