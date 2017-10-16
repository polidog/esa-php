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

    public function testCallPostCommentList()
    {
        $client = Phake::mock("GuzzleHttp\\Client");
        $apiMethods = new ApiMethods($client, 'bar');
        $apiMethods->comments(1, [
            'page' => 3
        ]);

        Phake::verify($client)->request("GET", "teams/bar/posts/1/comments", [
            'query' => [
                'page' => 3
            ]
        ]);
    }
}
