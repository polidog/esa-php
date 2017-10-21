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
composer.phar require polidog/esa-php
```

## Usage

```
<?php

require 'vendor/autoload.php';

$client = new Polidog\Esa\Client("<access_token>", "foobar");

$client->user();
// GET /v1/user

$client->teams();
// GET /v1/teams

$client->team('bar');
// GET /v1/teams/bar

$client->stats()
// GET /v1/teams/foobar/stats

$client->members();
// GET /v1/teams/foobar/members

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

// Comment API
$client->comments(1); /* post number */
// GET  /v1/teams/foobar/posts/1/comments

$client->createComment(1, ['body_md' => 'baz']);
// POST  /v1/teams/foobar/posts/1/comments

$client->comment(123); /* comment id */
// GET /v1/teams/foobar/comments/123

$client->updateComment(123, ['body_md' => 'bazbaz']);
// PATCH /v1/teams/foobar/comments/123

$client->deleteComment(123);
// DELETE /v1/teams/foobar/comments/123

$client->comments();
// GET /v1/teams/foobar/comments

$client->createSharing(1);
// POST /v1/teams/foobar/posts/1/sharing

$client->deleteSharing(1);
// DELETE /v1/teams/foobar/posts/1/sharing


# Star API
$client->postStargazers(1);
// GET /v1/teams/foobar/posts/1/stargazers

$client->addPostStar(1);
// POST /v1/teams/foobar/posts/1/star

$client->deletePostStar(1);
// DELETE /v1/teams/foobar/posts/1/star

$client->commentStargazers(123);
// GET /v1/teams/foobar/comments/123/stargazers

$client->addCommentStar(123);
// POST /v1/teams/foobar/comments/123/star

$client->deleteCommentStar(123);
// DELETE /v1/teams/foobar/comments/123/star


# Watch API
$client->watchers(1);
// GET /v1/teams/foobar/posts/1/watchers

$client->addWatch(1);
// POST /v1/teams/foobar/posts/1/watch

$client->deleteWtach(1);
// DELETE /v1/teams/foobar/posts/1/watch

# Categories API
$client->categories();
// GET /v1/teams/foobar/categories

# Tags API
$client->tags();
// GET /v1/teams/foobar/tags

# Invitation API
$client->invitation();
// GET /v1/teams/foobar/invitation

$client->regenerateInvitation();
// POST /v1/teams/foobar/invitation_regenerator

$client->pendingInvitations();
// GET /v1/teams/foobar/invitations

$client->sendInvitation(['test@test.com','test2@test.com']);
// POST /v1/teams/foobar/invitations

$client->cancelInvitation($code);
// DELETE /v1/teams/foobar/invitations/baz

# Emoji API
$client->emojis();
// GET /v1/teams/foobar/emojis

$client->createEmoji(['code' => 'team_emoji', image: '/path/to/image');
// POST /v1/teams/foobar/emojis

$client->createEmoji(['code' => 'alias_code', origin_code: 'team_emoji');
// POST /v1/teams/foobar/emojis

$client->deleteEmoji('team_emoji');
// DELETE /v1/teams/foobar/emojis/team_emoji
```

## Contributing

1. Fork it ( https://github.com/polidog/esa-php/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request

