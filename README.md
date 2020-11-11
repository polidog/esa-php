# esa-php

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

$api = \Polidog\Esa\Api::factory("<access_token>", "foobar");

$api->user();
// GET /v1/user

$api->teams();
// GET /v1/teams

$api->team('bar');
// GET /v1/teams/bar

$api->stats()
// GET /v1/teams/foobar/stats

$api->members();
// GET /v1/teams/foobar/members

$api->posts();
// GET /v1/teams/foobar/posts

$api->posts(["q" => "in:help"]);
// GET /v1/teams/foobar/posts?q=in%3Ahelp

$api->createPost(["name" => "foo"]);
// POST /v1/teams/foobar/posts

$api->updatePost(1, ["name" => "bar"]);
// PATCH /v1/teams/foobar/posts/1

$api->deletePost(1);
// DELETE /v1/teams/foobar/posts/1

// Comment API
$api->comments(1); /* post number */
// GET  /v1/teams/foobar/posts/1/comments

$api->createComment(1, ['body_md' => 'baz']);
// POST  /v1/teams/foobar/posts/1/comments

$api->comment(123); /* comment id */
// GET /v1/teams/foobar/comments/123

$api->updateComment(123, ['body_md' => 'bazbaz']);
// PATCH /v1/teams/foobar/comments/123

$api->deleteComment(123);
// DELETE /v1/teams/foobar/comments/123

$api->comments();
// GET /v1/teams/foobar/comments

$api->createSharing(1);
// POST /v1/teams/foobar/posts/1/sharing

$api->deleteSharing(1);
// DELETE /v1/teams/foobar/posts/1/sharing


# Star API
$api->postStargazers(1);
// GET /v1/teams/foobar/posts/1/stargazers

$api->addPostStar(1);
// POST /v1/teams/foobar/posts/1/star

$api->deletePostStar(1);
// DELETE /v1/teams/foobar/posts/1/star

$api->commentStargazers(123);
// GET /v1/teams/foobar/comments/123/stargazers

$api->addCommentStar(123);
// POST /v1/teams/foobar/comments/123/star

$api->deleteCommentStar(123);
// DELETE /v1/teams/foobar/comments/123/star


# Watch API
$api->watchers(1);
// GET /v1/teams/foobar/posts/1/watchers

$api->addWatch(1);
// POST /v1/teams/foobar/posts/1/watch

$api->deleteWtach(1);
// DELETE /v1/teams/foobar/posts/1/watch

# Categories API
$api->categories();
// GET /v1/teams/foobar/categories

# Tags API
$api->tags();
// GET /v1/teams/foobar/tags

# Invitation API
$api->invitation();
// GET /v1/teams/foobar/invitation

$api->regenerateInvitation();
// POST /v1/teams/foobar/invitation_regenerator

$api->pendingInvitations();
// GET /v1/teams/foobar/invitations

$api->sendInvitation(['test@test.com','test2@test.com']);
// POST /v1/teams/foobar/invitations

$api->cancelInvitation($code);
// DELETE /v1/teams/foobar/invitations/baz

# Emoji API
$api->emojis();
// GET /v1/teams/foobar/emojis

$api->createEmoji(['code' => 'team_emoji', image: '/path/to/image');
// POST /v1/teams/foobar/emojis

$api->createEmoji(['code' => 'alias_code', origin_code: 'team_emoji');
// POST /v1/teams/foobar/emojis

$api->deleteEmoji('team_emoji');
// DELETE /v1/teams/foobar/emojis/team_emoji
```

## Contributing

1. Fork it ( https://github.com/polidog/esa-php/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request

