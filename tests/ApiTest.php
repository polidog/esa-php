<?php

namespace Polidog\Esa\Test;

use PHPUnit\Framework\TestCase;
use Polidog\Esa\Api;
use Polidog\Esa\Client\ClientInterface;

class ApiTest extends TestCase
{
    private $client;

    protected function setUp()
    {
        $this->client = $this->prophesize(ClientInterface::class);
    }

    public function testFactory()
    {
        $api = Api::factory('token', 'team');
        $this->assertInstanceOf(Api::class, $api);
    }

    public function testUser()
    {
        $api = $this->getApiObject();
        $api->user();
        $this->client->request('GET', 'user', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testTeams()
    {
        $api = $this->getApiObject();
        $api->teams();
        $this->client->request('GET', 'teams')->shouldHaveBeenCalled();
    }

    public function testTeam()
    {
        $api = $this->getApiObject();
        $api->team('team_name');
        $this->client->request('GET', 'teams/team_name')->shouldHaveBeenCalled();
    }

    public function testStats()
    {
        $api = $this->getApiObject();
        $api->stats();
        $this->client->request('GET', 'teams/test/stats')->shouldHaveBeenCalled();
    }

    public function testMembers()
    {
        $api = $this->getApiObject();
        $api->members();
        $this->client->request('GET', 'teams/test/members')->shouldHaveBeenCalled();
    }

    public function testPosts()
    {
        $api = $this->getApiObject();
        $api->posts();
        $this->client->request('GET', 'teams/test/posts', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testPost()
    {
        $api = $this->getApiObject();
        $api->post(1);
        $this->client->request('GET', 'teams/test/posts/1')->shouldHaveBeenCalled();
    }

    public function testCreatePost()
    {
        $api = $this->getApiObject();
        $api->createPost(['name' => 'foo']);
        $this->client->request('POST', 'teams/test/posts', [
            'json' => [
                'post' => ['name' => 'foo'],
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testUpdatePost()
    {
        $api = $this->getApiObject();
        $api->updatePost(12, ['name' => 'bar']);
        $this->client->request('PATCH', 'teams/test/posts/12', [
            'json' => [
                'post' => ['name' => 'bar'],
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testDeletePost()
    {
        $api = $this->getApiObject();
        $api->deletePost(13);
        $this->client->request('DELETE', 'teams/test/posts/13')->shouldHaveBeenCalled();
    }

    public function testComments()
    {
        $api = $this->getApiObject();
        $api->comments();
        $this->client->request('GET', 'teams/test/comments', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testCommentsById()
    {
        $api = $this->getApiObject();
        $api->comments(1);
        $this->client->request('GET', 'teams/test/posts/1/comments', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testComment()
    {
        $api = $this->getApiObject();
        $api->comment(1);
        $this->client->request('GET', 'teams/test/comments/1', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testCreateComment()
    {
        $api = $this->getApiObject();
        $api->createComment(1, ['body_md' => 'baz']);
        $this->client->request('POST', 'teams/test/posts/1/comments', ['json' => [
            'comment' => [
                'body_md' => 'baz',
            ],
        ]])->shouldHaveBeenCalled();
    }

    public function testUpdateComment()
    {
        $api = $this->getApiObject();
        $api->updateComment(1, ['body_md' => 'foo']);
        $this->client->request('PATCH', 'teams/test/comments/1', ['json' => [
            'comment' => [
                'body_md' => 'foo',
            ],
        ]])->shouldHaveBeenCalled();
    }

    public function testDeleteCommand()
    {
        $api = $this->getApiObject();
        $api->deleteComment(1);
        $this->client->request('DELETE', 'teams/test/comments/1')->shouldHaveBeenCalled();
    }

    public function testCreateSharing()
    {
        $api = $this->getApiObject();
        $api->createSharing(1);
        $this->client->request('POST', 'teams/test/posts/1/sharing')->shouldHaveBeenCalled();
    }

    public function testDeleteSharing()
    {
        $api = $this->getApiObject();
        $api->deleteSharing(1);
        $this->client->request('DELETE', 'teams/test/posts/1/sharing')->shouldHaveBeenCalled();
    }

    public function testPostStargazers()
    {
        $api = $this->getApiObject();
        $api->postStargazers(1);
        $this->client->request('GET', 'teams/test/posts/1/stargazers', [
            'query' => [],
        ])->shouldHaveBeenCalled();
    }

    public function testAddPostStar()
    {
        $api = $this->getApiObject();
        $api->addPostStar(1, ['body' => 'foo bar']);
        $this->client->request('POST', 'teams/test/posts/1/star', [
            'json' => [
                'body' => 'foo bar',
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testDeletePostStar()
    {
        $api = $this->getApiObject();
        $api->deletePostStar(1);
        $this->client->request('DELETE', 'teams/test/posts/1/star')->shouldHaveBeenCalled();
    }

    public function testCommentStargazers()
    {
        $api = $this->getApiObject();
        $api->commentStargazers(1);
        $this->client->request('GET', 'teams/test/comments/1/stargazers', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testAddCommentStar()
    {
        $api = $this->getApiObject();
        $api->addCommentStar(1, ['body' => 'foo bar']);
        $this->client->request('POST', 'teams/test/comments/1/star', [
            'json' => [
                'body' => 'foo bar',
            ],
        ])->shouldHaveBeenCalled();
    }

    public function testDeleteCommentStar()
    {
        $api = $this->getApiObject();
        $api->deleteCommentStar(1);
        $this->client->request('DELETE', 'teams/test/comments/1/star')->shouldHaveBeenCalled();
    }

    public function testWatchers()
    {
        $api = $this->getApiObject();
        $api->watchers(1);
        $this->client->request('GET', 'teams/test/posts/1/watchers', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testAddWatch()
    {
        $api = $this->getApiObject();
        $api->addWatch(1);
        $this->client->request('POST', 'teams/test/posts/1/watch')->shouldHaveBeenCalled();
    }

    public function testDeleteWatch()
    {
        $api = $this->getApiObject();
        $api->deleteWatch(1);
        $this->client->request('DELETE', 'teams/test/posts/1/watch')->shouldHaveBeenCalled();
    }

    public function testCategories()
    {
        $api = $this->getApiObject();
        $api->categories();
        $this->client->request('GET', 'teams/test/categories')->shouldHaveBeenCalled();
    }

    public function testBatchMoveCategory()
    {
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

    public function testTags()
    {
        $api = $this->getApiObject();
        $api->tags();

        $this->client->request('GET', 'teams/test/tags')->shouldHaveBeenCalled();
    }

    public function testInvitation()
    {
        $api = $this->getApiObject();
        $api->invitation();
        $this->client->request('GET', 'teams/test/invitation')->shouldHaveBeenCalled();
    }

    public function testRegenerateInvitation()
    {
        $api = $this->getApiObject();
        $api->regenerateInvitation();
        $this->client->request('POST', 'teams/test/invitation_regenerator')->shouldHaveBeenCalled();
    }

    public function testPendingInvitations()
    {
        $api = $this->getApiObject();
        $api->pendingInvitations();
        $this->client->request('GET', 'teams/test/invitations', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testSendInvitation()
    {
        $api = $this->getApiObject();
        $api->sendInvitation(['polidogs@gmail.com']);
        $this->client->request('POST', 'teams/test/invitations', ['json' => [
            'members' => [
                'emails' => ['polidogs@gmail.com'],
            ],
        ]])->shouldHaveBeenCalled();
    }

    public function testCancelInvitation()
    {
        $api = $this->getApiObject();
        $api->cancelInvitation('code');
        $this->client->request('DELETE', 'teams/test/invitations/code')->shouldHaveBeenCalled();
    }

    public function testEmojis()
    {
        $api = $this->getApiObject();
        $api->emojis();
        $this->client->request('GET', 'teams/test/emojis', ['query' => []])->shouldHaveBeenCalled();
    }

    public function testCreateEmoji()
    {
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

    public function testDeleteEmoji()
    {
        $api = $this->getApiObject();
        $api->deleteEmoji('code');
        $this->client->request('DELETE', 'teams/test/emojis/code')->shouldHaveBeenCalled();
    }

    private function getApiObject()
    {
        return new Api($this->client->reveal(), 'test');
    }
}
