<?php

namespace Polidog\Esa;

use Polidog\Esa\Client\Client;
use Polidog\Esa\Client\ClientInterface;


/**
 * Class ApiMethods.
 */
class Api
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $currentTeam;

    /**
     * @param ClientInterface $client
     * @param string $currentTeam
     */
    public function __construct(ClientInterface $client, $currentTeam)
    {
        $this->client = $client;
        $this->currentTeam = $currentTeam;
    }

    /**
     * @param array $params
     * @param null  $headers
     */
    public function user(array $params = [])
    {
        return $this->client->request('GET', 'user', [
            'query' => $params,
        ]);
    }

    /**
     * @return array
     */
    public function teams()
    {
        return $this->client->request('GET', 'teams');
    }

    /**
     * @param null $name
     *
     * @return array
     */
    public function team($name = null)
    {
        return $this->client->request('GET', "teams/{$name}");
    }

    /**
     * @return array
     */
    public function stats()
    {
        return $this->client->request('GET', "teams/{$this->currentTeam}/stats");
    }

    /**
     * @return array
     */
    public function members()
    {
        return $this->client->request('GET', "teams/{$this->currentTeam}/members");
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function posts(array $params = [])
    {
        return $this->client->request('GET', "teams/{$this->currentTeam}/posts", [
            'query' => $params,
        ]);
    }

    /**
     * @param $number
     *
     * @return array
     */
    public function post($number)
    {
        return $this->client->request('GET', "teams/{$this->currentTeam}/posts/{$number}");
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function createPost($data)
    {
        return $this->client->request('POST', "teams/{$this->currentTeam}/posts", [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    /**
     * @param $number
     * @param $data
     *
     * @return array
     */
    public function updatePost($number, $data)
    {
        return $this->client->request('PATCH', "teams/{$this->currentTeam}/posts/{$number}", [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    /**
     * @param $number
     *
     * @return array
     */
    public function deletePost($number)
    {
        return $this->client->request('DELETE', "teams/{$this->currentTeam}/posts/{$number}");
    }

    /**
     * @param int   $number
     * @param array $params
     *
     * @return array
     */
    public function comments($number = null, $params = [])
    {
        if (empty($number)) {
            return $this->client->request('GET', "teams/{$this->currentTeam}/comments", [
                'query' => $params,
            ]);
        }

        return $this->client->request('GET', "teams/{$this->currentTeam}/posts/{$number}/comments", [
            'query' => $params,
        ]);
    }

    /**
     * @param       $commentId
     * @param array $params
     *
     * @return array
     */
    public function comment($commentId, $params = [])
    {
        return $this->client->request('GET', "teams/{$this->currentTeam}/comments/{$commentId}", [
            'query' => $params,
        ]);
    }

    /**
     * @param $postNumber
     * @param $data
     *
     * @return array
     */
    public function createComment($postNumber, $data)
    {
        return $this->client->request('POST', "teams/{$this->currentTeam}/posts/{$postNumber}/comments", [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    /**
     * @param $commentId
     * @param $data
     *
     * @return array
     */
    public function updateComment($commentId, $data)
    {
        return $this->client->request('PATCH', "teams/{$this->currentTeam}/comments/{$commentId}", [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    /**
     * @param $commentId
     *
     * @return array
     */
    public function deleteComment($commentId)
    {
        return $this->client->request('DELETE', "teams/{$this->currentTeam}/comments/{$commentId}");
    }

    /**
     * @param $postNumber
     * @return array
     */
    public function createSharing($postNumber)
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    /**
     * @param $postNumber
     * @return array
     */
    public function deleteSharing($postNumber)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    /**
     * @param       $postNumber
     * @param array $params
     *
     * @return array
     */
    public function postStargazers($postNumber, $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/stargazers"), [
            'query' => $params,
        ]);
    }

    /**
     * @param       $postNumber
     * @param array $params
     *
     * @return array
     */
    public function addPostStar($postNumber, $params = [])
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/star"), [
            'json' => $params,
        ]);
    }

    /**
     * @param $postNumber
     *
     * @return array
     */
    public function deletePostStar($postNumber)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/star"));
    }

    /**
     * @param       $commentId
     * @param array $params
     *
     * @return array
     */
    public function commentStargazers($commentId, $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("comments/{$commentId}/star"), [
            'query' => $params,
        ]);
    }

    /**
     * @param       $commentId
     * @param array $params
     *
     * @return array
     */
    public function addCommentStar($commentId, $params = [])
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("comments/{$commentId}/star"), [
            'json' => $params,
        ]);
    }

    /**
     * @param $commentId
     *
     * @return array
     */
    public function deleteCommentStar($commentId)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("comments/{$commentId}/star"));
    }

    /**
     * @param       $postNumber
     * @param array $params
     *
     * @return array
     */
    public function watchers($postNumber, $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/watchers"), [
            'query' => $params,
        ]);
    }

    /**
     * @param $postNumber
     *
     * @return array
     */
    public function addWatch($postNumber)
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/watch"));
    }

    /**
     * @param $postNumber
     *
     * @return array
     */
    public function deleteWatch($postNumber)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/watch"));
    }

    /**
     * @return array
     */
    public function categories()
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('categories'));
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function batchMoveCategory($params = [])
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('categories/batch_move'), [
            'json' => $params,
        ]);
    }

    /**
     * @return array
     */
    public function tags()
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('tags'));
    }

    /**
     * @return array
     */
    public function invitation()
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('invitation'));
    }

    /**
     * @return array
     */
    public function regenerateInvitation()
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('invitation_regenerator'));
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function pendingInvitations(array $params)
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('invitations'), [
            'query' => $params,
        ]);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function sendInvitation(array $data)
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('invitations'), [
            'json' => [
                'members' => $data,
            ],
        ]);
    }

    /**
     * @param string $code
     *
     * @return array
     */
    public function cancelInvitation($code)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("invitations/{$code}"));
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function emojis(array $params = [])
    {
        return $this->client->request('GET', "teams/{$this->currentTeam}/emojis", [
            'query' => $params,
        ]);
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function createEmoji($data)
    {
        return $this->client->request('POST', "teams/{$this->currentTeam}/emojis", [
            'json' => [
                'emoji' => $data,
            ],
        ]);
    }

    /**
     * @param $code
     *
     * @return array
     */
    public function deleteEmoji($code)
    {
        return $this->client->request('DELETE', "teams/{$this->currentTeam}/emojis/{$code}");
    }

    public static function factory($accessToken, $currentTeam)
    {
        $client = Client::factory($accessToken, $currentTeam);
        return new self($client, $currentTeam);
    }

    private function getCurrentTeamUrl($path = '')
    {
        return "teams/{$this->currentTeam}/$path";
    }
}
