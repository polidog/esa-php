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
     * @param string          $currentTeam
     */
    public function __construct(ClientInterface $client, $currentTeam)
    {
        $this->client = $client;
        $this->currentTeam = $currentTeam;
    }

    /**
     * @param array $params
     *
     * @return array
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
     * @param string|null $name
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
        return $this->client->request('GET', $this->getCurrentTeamUrl('stats'));
    }

    /**
     * @return array
     */
    public function members()
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('members'));
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function posts(array $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('posts'), [
            'query' => $params,
        ]);
    }

    /**
     * @param int $number
     *
     * @return array
     */
    public function post($number)
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$number}"));
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function createPost($data)
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('posts'), [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    /**
     * @param int   $number
     * @param array $data
     *
     * @return array
     */
    public function updatePost($number, array $data)
    {
        return $this->client->request('PATCH', $this->getCurrentTeamUrl("posts/{$number}"), [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    /**
     * @param int $number
     *
     * @return array
     */
    public function deletePost($number)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$number}"));
    }

    /**
     * @param int   $number
     * @param array $params
     *
     * @return array
     */
    public function comments($number = null, array $params = [])
    {
        if (empty($number)) {
            return $this->client->request('GET', $this->getCurrentTeamUrl('comments'), [
                'query' => $params,
            ]);
        }

        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$number}/comments"), [
            'query' => $params,
        ]);
    }

    /**
     * @param int   $commentId
     * @param array $params
     *
     * @return array
     */
    public function comment($commentId, array $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("comments/{$commentId}"), [
            'query' => $params,
        ]);
    }

    /**
     * @param int   $postNumber
     * @param array $data
     *
     * @return array
     */
    public function createComment($postNumber, array $data)
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/comments"), [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    /**
     * @param int   $commentId
     * @param array $data
     *
     * @return array
     */
    public function updateComment($commentId, array $data)
    {
        return $this->client->request('PATCH', $this->getCurrentTeamUrl("comments/{$commentId}"), [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    /**
     * @param int $commentId
     *
     * @return array
     */
    public function deleteComment($commentId)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("comments/{$commentId}"));
    }

    /**
     * @param int $postNumber
     *
     * @return array
     */
    public function createSharing($postNumber)
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    /**
     * @param int $postNumber
     *
     * @return array
     */
    public function deleteSharing($postNumber)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    /**
     * @param int   $postNumber
     * @param array $params
     *
     * @return array
     */
    public function postStargazers($postNumber, array $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/stargazers"), [
            'query' => $params,
        ]);
    }

    /**
     * @param int   $postNumber
     * @param array $params
     *
     * @return array
     */
    public function addPostStar($postNumber, array $params = [])
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/star"), [
            'json' => $params,
        ]);
    }

    /**
     * @param int $postNumber
     *
     * @return array
     */
    public function deletePostStar($postNumber)
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/star"));
    }

    /**
     * @param int   $commentId
     * @param array $params
     *
     * @return array
     */
    public function commentStargazers($commentId, array $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("comments/{$commentId}/stargazers"), [
            'query' => $params,
        ]);
    }

    /**
     * @param       $commentId
     * @param array $params
     *
     * @return array
     */
    public function addCommentStar($commentId, array $params = [])
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
     * @param integer$postNumber
     * @param array $params
     *
     * @return array
     */
    public function watchers($postNumber, array $params = [])
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
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/watch"));
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
    public function batchMoveCategory(array $params = [])
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
    public function pendingInvitations(array $params = [])
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('invitations'), [
            'query' => $params,
        ]);
    }

    /**
     * @param array $emails
     *
     * @return array
     */
    public function sendInvitation(array $emails)
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('invitations'), [
            'json' => [
                'members' => ['emails' => $emails],
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
        return $this->client->request('GET', $this->getCurrentTeamUrl('emojis'), [
            'query' => $params,
        ]);
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function createEmoji(array $data)
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('emojis'), [
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

    /**
     * @param $accessToken
     * @param $currentTeam
     *
     * @return Api
     */
    public static function factory($accessToken, $currentTeam)
    {
        $client = Client::factory($accessToken);

        return new self($client, $currentTeam);
    }

    private function getCurrentTeamUrl($path = '')
    {
        return "teams/{$this->currentTeam}/$path";
    }
}
