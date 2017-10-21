<?php
namespace Polidog\Esa;

use Phake;

class ApiMethodsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function callApiTeams()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->teams();

        Phake::verify($client)->request("GET", "teams");
    }

    /**
     * @test
     */
    public function callApiTeam()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->team("foo");

        Phake::verify($client)->request("GET", "teams/foo");
    }

    /**
     * @test
     */
    public function callApiPosts()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->posts(["q" => "in:help"]);

        Phake::verify($client)->request("GET","teams/bar/posts",[
            "query" => [
                "q" => "in:help"
            ]
        ]);
    }

    /**
     * @test
     */
    public function callApiPost()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->post(1);

        Phake::verify($client)->request("GET","teams/bar/posts/1");

    }

    /**
     * @test
     */
    public function callApiCreatePost()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->createPost([
            "name" => "hogehoge"
        ]);

        Phake::verify($client)->request("POST","teams/bar/posts",[
            "json" => [
                "post" => [
                    "name" => "hogehoge"
                ]
            ]
        ]);

    }

    /**
     * @test
     */
    public function callApiUpdatePost()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->updatePost(1,[
            "name" => "fuga"
        ]);

        Phake::verify($client)->request("PATCH","teams/bar/posts/1",[
            "json" => [
                "post" => [
                    "name" => "fuga"
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function callApiDeletePost()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->deletePost(1);

        Phake::verify($client)->request("DELETE","teams/bar/posts/1");

    }

    /**
     * @test
     */
    public function callApiEmoji()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->emojis(["include" => "all"]);

        Phake::verify($client)->request("GET","teams/bar/emojis",[
            "query" => [
                "include" => "all"
            ]
        ]);
    }

    /**
     * @test
     */
    public function callApiCreateEmoji()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->createEmoji([
            "code" => "team_emoji",
            "image" => "base64_string"
        ]);

        Phake::verify($client)->request("POST","teams/bar/emojis",[
            "json" => [
                "emoji" => [
                    "code" => "team_emoji",
                    "image" => "base64_string"
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function callApiDeleteEmoji()
    {
        $client = Phake::mock("GuzzleHttp\\Client");

        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->deleteEmoji("team_emoji");

        Phake::verify($client)->request("DELETE","teams/bar/emojis/team_emoji");
    }

    public function testCallApiUser()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->user([
            'include' => 'teams'
        ]);

        Phake::verify($client)->request("GET", "user", [
            'query' => [
                'include' => 'teams'
            ]
        ]);
    }

    public function testCallCommentList()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->comments(null, [
            'page' => 3
        ]);

        Phake::verify($client)->request("GET", "teams/bar/comments", [
            'query' => [
                'page' => 3
            ]
        ]);
    }

    public function testCallComment()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->comment(1,[
            'include' => 'stargazers'
        ]);

        Phake::verify($client)->request("GET", "teams/bar/comments/1", [
            'query' => [
                'include' => 'stargazers'
            ]
        ]);
    }

    public function testCreateComment()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $bodyMd = 'LGTM!!';

        $apiMethods->createComment(2,[
            'body_md' => $bodyMd
        ]);

        Phake::verify($client)->request("POST", "teams/bar/posts/2/comments", [
            'json' => [
                'comment' => [
                    'body_md' => $bodyMd
                ]
            ]
        ]);

    }

    public function testUpdateComment()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $bodyMd = 'LGTM!!';

        $apiMethods->updateComment(22767,[
            'body_md' => $bodyMd
        ]);

        Phake::verify($client)->request("PATCH", "teams/bar/comments/22767", [
            'json' => [
                'comment' => [
                    'body_md' => $bodyMd
                ]
            ]
        ]);
    }

    public function testDeleteComment()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->deleteComment(22767);

        Phake::verify($client)->request("DELETE", "teams/bar/comments/22767");
    }

    public function testMembers()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->members();

        Phake::verify($client)->request('GET', "teams/bar/members");
    }

    public function testPostStargazers()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->postStargazers(2312, [
            'page' => 2,
            'per_page' => 30,
        ]);

        Phake::verify($client)->request('GET', "teams/bar/posts/2312/stargazers",[
            'query' => [
                'page' => 2,
                'per_page' => 30,
            ]
        ]);

    }

    public function testAddPostStar()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->addPostStar(123,[
            'body' => 'foo bar'
        ]);

        Phake::verify($client)->request('POST', 'teams/bar/posts/123/star',[
            'json' => [
                'body' => 'foo bar'
            ]
        ]);
    }

    public function testDeletePostStar()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->deletePostStar(123);

        Phake::verify($client)->request('DELETE', 'teams/bar/posts/123/star');
    }

    public function testCommentStargazers()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->commentStargazers(123,[
            'page' => 2,
            'par_page' => 20,
        ]);

        Phake::verify($client)->request('GET', 'teams/bar/comments/123/star',[
            'query' => [
                'page' => 2,
                'par_page' => 20
            ]
        ]);
    }

    public function testAddCommentStar()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->addCommentStar(123,[
            'body' => 'foo bar'
        ]);

        Phake::verify($client)->request('POST', 'teams/bar/comments/123/star',[
            'json' => [
                'body' => 'foo bar'
            ]
        ]);
    }

    public function testDeleteCommentStar()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->deleteCommentStar(123);

        Phake::verify($client)->request('DELETE', 'teams/bar/comments/123/star');
    }

    public function testWatchers()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->watchers(2312, [
            'page' => 2,
            'par_page' => 30
        ]);

        Phake::verify($client)->request('GET', 'teams/bar/posts/2312/watchers',[
            'query' => [
                'page' => 2,
                'par_page' => 30
            ]
        ]);
    }

    public function testAddWatch()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->addWatch(2312);

        Phake::verify($client)->request('GET', 'teams/bar/posts/2312/watch');
    }

    public function testDeleteWatch()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->deleteWatch(2312);

        Phake::verify($client)->request('DELETE', 'teams/bar/posts/2312/watch');

    }

    public function testCategories()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->categories(['page' => 1]);
        Phake::verify($client)->request('GET', 'teams/bar/categories');
    }

    public function testBatchMoveCategory()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->batchMoveCategory([
            'from' => '/foo/bar/',
            'to' => '/baz/'
        ]);

        Phake::verify($client)->request('POST', 'teams/bar/categories/batch_move',[
            'json' => [
                'from' => '/foo/bar/',
                'to' => '/baz/'
            ]
        ]);
    }

    public function testTags()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->tags();

        Phake::verify($client)->request('GET', 'teams/bar/tags');
    }

    public function testPendingInvitations()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->pendingInvitations([
            'page' => 2,
            'par_page' => 35
        ]);

        Phake::verify($client)->request('GET', 'teams/bar/invitations',[
            'query' => [
                'page' => 2,
                'par_page' => 35,
            ]
        ]);

    }

    public function testSendInvitation()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->sendInvitation([
            'test@test.com',
            'test2@test.com'
        ]);
        Phake::verify($client)->request('POST', 'teams/bar/invitations',[
            'json' => [
                'members' => [
                    'test@test.com',
                    'test2@test.com'
                ]
            ]
        ]);

    }

    public function testCancelInvitation()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');

        $apiMethods->cancelInvitation('mee93383edf699b525e01842d34078e28');

        Phake::verify($client)->request('DELETE', 'teams/bar/invitations/mee93383edf699b525e01842d34078e28');
    }
}
