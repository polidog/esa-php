<?php

declare(strict_types=1);

namespace Polidog\Esa\Test;

use PHPUnit\Framework\TestCase;
use Polidog\Esa\Api;
use Polidog\Esa\Client\ClientInterface;
use Prophecy\PhpUnit\ProphecyTrait;

final class ApiTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var \Prophecy\Prophecy\ObjectProphecy|ClientInterface
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = $this->prophesize(ClientInterface::class);
    }

    public function testFactory(): void
    {
        $api = Api::factory('token', 'team');
        $this->assertInstanceOf(Api::class, $api);
    }

    public function testUser(): void
    {
        $this->client->request('GET', 'user', [
            'query' => [],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->user();
        $this->client->request('GET', 'user', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testTeams(): void
    {
        $this->client->request('GET', 'teams')->willReturn([]);
        $api = $this->getApiObject();
        $api->teams();
        $this->client->request('GET', 'teams')->shouldHaveBeenCalled();
    }

    public function testTeam(): void
    {
        $this->client->request('GET', 'teams/team_name')->willReturn([]);
        $api = $this->getApiObject();
        $api->team('team_name');
        $this->client->request('GET', 'teams/team_name')->shouldHaveBeenCalled();
    }

    public function testStats(): void
    {
        $this->client->request('GET', 'teams/test/stats')->willReturn([]);

        $api = $this->getApiObject();
        $api->stats();
        $this->client->request('GET', 'teams/test/stats')->shouldHaveBeenCalled();
    }

    public function testMembers(): void
    {
        $this->client->request('GET', 'teams/test/members')->willReturn([]);
        $api = $this->getApiObject();
        $api->members();
        $this->client->request('GET', 'teams/test/members')->shouldHaveBeenCalled();
    }

    public function testPosts(): void
    {
        $this->client->request('GET', 'teams/test/posts', [
            'query' => [],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->posts();
        $this->client->request('GET', 'teams/test/posts', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testPost(): void
    {
        $this->client->request('GET', 'teams/test/posts/1')->willReturn([]);

        $api = $this->getApiObject();
        $api->post(1);
        $this->client->request('GET', 'teams/test/posts/1')->shouldHaveBeenCalled();
    }

    public function testCreatePost(): void
    {
        $this->client->request('POST', 'teams/test/posts', [
            'json' => [
                'post' => ['name' => 'foo'],
            ],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->createPost(['name' => 'foo']);
        $this->client->request('POST', 'teams/test/posts', [
            'json' => [
                'post' => ['name' => 'foo'],
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testUpdatePost(): void
    {
        $this->client->request('PATCH', 'teams/test/posts/12', [
            'json' => [
                'post' => ['name' => 'bar'],
            ],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->updatePost(12, ['name' => 'bar']);
        $this->client->request('PATCH', 'teams/test/posts/12', [
            'json' => [
                'post' => ['name' => 'bar'],
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testDeletePost(): void
    {
        $this->client->request('DELETE', 'teams/test/posts/13')->willReturn([]);

        $api = $this->getApiObject();
        $api->deletePost(13);
        $this->client->request('DELETE', 'teams/test/posts/13')->shouldHaveBeenCalled();
    }

    public function testComments(): void
    {
        $this->client->request('GET', 'teams/test/comments', [
            'query' => [],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->comments();
        $this->client->request('GET', 'teams/test/comments', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testCommentsById(): void
    {
        $this->client->request('GET', 'teams/test/posts/1/comments', [
            'query' => [],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->comments(1);
        $this->client->request('GET', 'teams/test/posts/1/comments', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testComment(): void
    {
        $this->client->request('GET', 'teams/test/comments/1', ['query' => []])->willReturn([]);
        $api = $this->getApiObject();
        $api->comment(1);
        $this->client->request('GET', 'teams/test/comments/1', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testCreateComment(): void
    {
        $this->client->request('POST', 'teams/test/posts/1/comments', ['json' => [
            'comment' => [
                'body_md' => 'baz',
            ],
        ]])->willReturn([]);

        $api = $this->getApiObject();
        $api->createComment(1, ['body_md' => 'baz']);
        $this->client->request('POST', 'teams/test/posts/1/comments', ['json' => [
            'comment' => [
                'body_md' => 'baz',
            ],
        ]])->shouldHaveBeenCalled();
    }

    public function testUpdateComment(): void
    {
        $this->client->request('PATCH', 'teams/test/comments/1', ['json' => [
            'comment' => [
                'body_md' => 'foo',
            ],
        ]])->willReturn([]);

        $api = $this->getApiObject();
        $api->updateComment(1, ['body_md' => 'foo']);
        $this->client->request('PATCH', 'teams/test/comments/1', ['json' => [
            'comment' => [
                'body_md' => 'foo',
            ],
        ]])->shouldHaveBeenCalled();
    }

    public function testDeleteCommand(): void
    {
        $this->client->request('DELETE', 'teams/test/comments/1')->willReturn([]);

        $api = $this->getApiObject();
        $api->deleteComment(1);
        $this->client->request('DELETE', 'teams/test/comments/1')->shouldHaveBeenCalled();
    }

    public function testCreateSharing(): void
    {
        $this->client->request('POST', 'teams/test/posts/1/sharing')->willReturn([]);

        $api = $this->getApiObject();
        $api->createSharing(1);
        $this->client->request('POST', 'teams/test/posts/1/sharing')->shouldHaveBeenCalled();
    }

    public function testDeleteSharing(): void
    {
        $this->client->request('DELETE', 'teams/test/posts/1/sharing')->willReturn([]);

        $api = $this->getApiObject();
        $api->deleteSharing(1);
        $this->client->request('DELETE', 'teams/test/posts/1/sharing')->shouldHaveBeenCalled();
    }

    public function testPostStargazers(): void
    {
        $this->client->request('GET', 'teams/test/posts/1/stargazers', [
            'query' => [],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->postStargazers(1);
        $this->client->request('GET', 'teams/test/posts/1/stargazers', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testAddPostStar(): void
    {
        $this->client->request('POST', 'teams/test/posts/1/star', [
            'json' => [
                'body' => 'foo bar',
            ],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->addPostStar(1, ['body' => 'foo bar']);
        $this->client->request('POST', 'teams/test/posts/1/star', [
            'json' => [
                'body' => 'foo bar',
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testDeletePostStar(): void
    {
        $this->client->request('DELETE', 'teams/test/posts/1/star')->willReturn([]);

        $api = $this->getApiObject();
        $api->deletePostStar(1);
        $this->client->request('DELETE', 'teams/test/posts/1/star')->shouldHaveBeenCalled();
    }

    public function testCommentStargazers(): void
    {
        $this->client->request('GET', 'teams/test/comments/1/stargazers', ['query' => []])->willReturn([]);

        $api = $this->getApiObject();
        $api->commentStargazers(1);
        $this->client->request('GET', 'teams/test/comments/1/stargazers', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testAddCommentStar(): void
    {
        $this->client->request('POST', 'teams/test/comments/1/star', [
            'json' => [
                'body' => 'foo bar',
            ],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->addCommentStar(1, ['body' => 'foo bar']);
        $this->client->request('POST', 'teams/test/comments/1/star', [
            'json' => [
                'body' => 'foo bar',
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testDeleteCommentStar(): void
    {
        $this->client->request('DELETE', 'teams/test/comments/1/star')->willReturn([]);

        $api = $this->getApiObject();
        $api->deleteCommentStar(1);
        $this->client->request('DELETE', 'teams/test/comments/1/star')->shouldHaveBeenCalled();
    }

    public function testWatchers(): void
    {
        $this->client->request('GET', 'teams/test/posts/1/watchers', ['query' => []])->willReturn([]);

        $api = $this->getApiObject();
        $api->watchers(1);
        $this->client->request('GET', 'teams/test/posts/1/watchers', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testAddWatch(): void
    {
        $this->client->request('POST', 'teams/test/posts/1/watch')->willReturn([]);

        $api = $this->getApiObject();
        $api->addWatch(1);
        $this->client->request('POST', 'teams/test/posts/1/watch')->shouldHaveBeenCalled();
    }

    public function testDeleteWatch(): void
    {
        $this->client->request('DELETE', 'teams/test/posts/1/watch')->willReturn([]);

        $api = $this->getApiObject();
        $api->deleteWatch(1);
        $this->client->request('DELETE', 'teams/test/posts/1/watch')->shouldHaveBeenCalled();
    }

    public function testCategories(): void
    {
        $this->client->request('GET', 'teams/test/categories')->willReturn([]);

        $api = $this->getApiObject();
        $api->categories();
        $this->client->request('GET', 'teams/test/categories')->shouldHaveBeenCalled();
    }

    public function testBatchMoveCategory(): void
    {
        $this->client->request('POST', 'teams/test/categories/batch_move', [
            'json' => [
                'from' => '/foo/bar',
                'to' => '/biz',
            ],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->batchMoveCategory([
            'from' => '/foo/bar',
            'to' => '/biz',
        ]);

        $this->client->request('POST', 'teams/test/categories/batch_move', [
            'json' => [
                'from' => '/foo/bar',
                'to' => '/biz',
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testTags(): void
    {
        $this->client->request('GET', 'teams/test/tags')->willReturn([]);

        $api = $this->getApiObject();
        $api->tags();

        $this->client->request('GET', 'teams/test/tags')->shouldHaveBeenCalled();
    }

    public function testInvitation(): void
    {
        $this->client->request('GET', 'teams/test/invitation')->willReturn([]);

        $api = $this->getApiObject();
        $api->invitation();
        $this->client->request('GET', 'teams/test/invitation')->shouldHaveBeenCalled();
    }

    public function testRegenerateInvitation(): void
    {
        $this->client->request('POST', 'teams/test/invitation_regenerator')->willReturn([]);

        $api = $this->getApiObject();
        $api->regenerateInvitation();
        $this->client->request('POST', 'teams/test/invitation_regenerator')->shouldHaveBeenCalled();
    }

    public function testPendingInvitations(): void
    {
        $this->client->request('GET', 'teams/test/invitations', ['query' => []])->willReturn([]);

        $api = $this->getApiObject();
        $api->pendingInvitations();
        $this->client->request('GET', 'teams/test/invitations', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testSendInvitation(): void
    {
        $this->client->request('POST', 'teams/test/invitations', ['json' => [
            'members' => [
                'emails' => ['polidogs@gmail.com'],
            ],
        ]])->willReturn([]);

        $api = $this->getApiObject();
        $api->sendInvitation(['polidogs@gmail.com']);
        $this->client->request('POST', 'teams/test/invitations', ['json' => [
            'members' => [
                'emails' => ['polidogs@gmail.com'],
            ],
        ]])->shouldHaveBeenCalled();
    }

    public function testCancelInvitation(): void
    {
        $this->client->request('DELETE', 'teams/test/invitations/code')->willReturn([]);

        $api = $this->getApiObject();
        $api->cancelInvitation('code');
        $this->client->request('DELETE', 'teams/test/invitations/code')->shouldHaveBeenCalled();
    }

    public function testEmojis(): void
    {
        $this->client->request('GET', 'teams/test/emojis', ['query' => []])->willReturn([]);

        $api = $this->getApiObject();
        $api->emojis();
        $this->client->request('GET', 'teams/test/emojis', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testCreateEmoji(): void
    {
        $this->client->request('POST', 'teams/test/emojis', [
            'json' => [
                'emoji' => [
                    'code' => 'team_emoji',
                    'image' => 'base64...',
                ],
            ],
        ])->willReturn([]);

        $api = $this->getApiObject();
        $api->createEmoji([
            'code' => 'team_emoji',
            'image' => 'base64...',
        ]);

        $this->client->request('POST', 'teams/test/emojis', [
            'json' => [
                'emoji' => [
                    'code' => 'team_emoji',
                    'image' => 'base64...',
                ],
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testDeleteEmoji(): void
    {
        $this->client->request('DELETE', 'teams/test/emojis/code')->willReturn([]);

        $api = $this->getApiObject();
        $api->deleteEmoji('code');
        $this->client->request('DELETE', 'teams/test/emojis/code')->shouldHaveBeenCalled();
    }

    private function getApiObject(): Api
    {
        return new Api($this->client->reveal(), 'test');
    }
}
