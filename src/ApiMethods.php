<?php

namespace Polidog\Esa;

use GuzzleHttp\ClientInterface;

/**
 * Class ApiMethods.
 */
class ApiMethods
{
    private $httpClient;
    private $currentTeam;

    /**
     * @param ClientInterface $client
     * @param $currentTeam
     */
    public function __construct(ClientInterface $client, $currentTeam)
    {
        $this->httpClient = $client;
        $this->currentTeam = $currentTeam;
    }

    /**
     * @param array $params
     * @param null  $headers
     */
    public function user(array $params = [])
    {
        return $this->httpClient->request('GET', 'user', [
            'query' => $params,
        ]);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function teams()
    {
        return $this->httpClient->request('GET', 'teams');
    }

    /**
     * @param null $name
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function team($name = null)
    {
        return $this->httpClient->request('GET', "teams/{$name}");
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function stats()
    {
        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/stats");
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function members()
    {
        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/members");
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function posts(array $params = [])
    {
        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/posts", [
            'query' => $params,
        ]);
    }

    /**
     * @param $number
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($number)
    {
        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/posts/{$number}");
    }

    /**
     * @param $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createPost($data)
    {
        return $this->httpClient->request('POST', "teams/{$this->currentTeam}/posts", [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    /**
     * @param $number
     * @param $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updatePost($number, $data)
    {
        return $this->httpClient->request('PATCH', "teams/{$this->currentTeam}/posts/{$number}", [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    /**
     * @param $number
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deletePost($number)
    {
        return $this->httpClient->request('DELETE', "teams/{$this->currentTeam}/posts/{$number}");
    }

    /**
     * @param int   $number
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function comments($number = null, $params = [])
    {
        if (empty($number)) {
            return $this->httpClient->request('GET', "teams/{$this->currentTeam}/comments", [
                'query' => $params,
            ]);
        }

        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/posts/{$number}/comments", [
            'query' => $params,
        ]);
    }

    /**
     * @param       $commentId
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function comment($commentId, $params = [])
    {
        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/comments/{$commentId}", [
            'query' => $params,
        ]);
    }

    /**
     * @param $postNumber
     * @param $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createComment($postNumber, $data)
    {
        return $this->httpClient->request('POST', "teams/{$this->currentTeam}/posts/{$postNumber}/comments", [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    /**
     * @param $commentId
     * @param $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updateComment($commentId, $data)
    {
        return $this->httpClient->request('PATCH', "teams/{$this->currentTeam}/comments/{$commentId}", [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    /**
     * @param $commentId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteComment($commentId)
    {
        return $this->httpClient->request('DELETE', "teams/{$this->currentTeam}/comments/{$commentId}");
    }

    /**
     * @param $postNumber
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createSharing($postNumber)
    {
        return $this->httpClient->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    /**
     * @param $postNumber
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteSharing($postNumber)
    {
        return $this->httpClient->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    /**
     * @param       $postNumber
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function postStargazers($postNumber, $params = [])
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/stargazers"), [
            'query' => $params,
        ]);
    }

    /**
     * @param       $postNumber
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addPostStar($postNumber, $params = [])
    {
        return $this->httpClient->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/star"), [
            'json' => $params,
        ]);
    }

    /**
     * @param $postNumber
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deletePostStar($postNumber)
    {
        return $this->httpClient->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/star"));
    }

    /**
     * @param       $commentId
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function commentStargazers($commentId, $params = [])
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl("comments/{$commentId}/star"), [
            'query' => $params,
        ]);
    }

    /**
     * @param       $commentId
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addCommentStar($commentId, $params = [])
    {
        return $this->httpClient->request('POST', $this->getCurrentTeamUrl("comments/{$commentId}/star"), [
            'json' => $params,
        ]);
    }

    /**
     * @param $commentId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteCommentStar($commentId)
    {
        return $this->httpClient->request('DELETE', $this->getCurrentTeamUrl("comments/{$commentId}/star"));
    }

    /**
     * @param       $postNumber
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function watchers($postNumber, $params = [])
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/watchers"), [
            'query' => $params,
        ]);
    }

    /**
     * @param $postNumber
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addWatch($postNumber)
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/watch"));
    }

    /**
     * @param $postNumber
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteWatch($postNumber)
    {
        return $this->httpClient->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/watch"));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function categories()
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl('categories'));
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function batchMoveCategory($params = [])
    {
        return $this->httpClient->request('POST', $this->getCurrentTeamUrl('categories/batch_move'), [
            'json' => $params,
        ]);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function tags()
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl('tags'));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function invitation()
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl('invitation'));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function regenerateInvitation()
    {
        return $this->httpClient->request('POST', $this->getCurrentTeamUrl('invitation_regenerator'));
    }

    /**
     * @param $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function pendingInvitations(array $params)
    {
        return $this->httpClient->request('GET', $this->getCurrentTeamUrl('invitations'), [
            'query' => $params,
        ]);
    }

    /**
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendInvitation(array $data)
    {
        return $this->httpClient->request('POST', $this->getCurrentTeamUrl('invitations'), [
            'json' => [
                'members' => $data,
            ],
        ]);
    }

    /**
     * @param string $code
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function cancelInvitation($code)
    {
        return $this->httpClient->request('DELETE', $this->getCurrentTeamUrl("invitations/{$code}"));
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function emojis(array $params = [])
    {
        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/emojis", [
            'query' => $params,
        ]);
    }

    /**
     * @param $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createEmoji($data)
    {
        return $this->httpClient->request('POST', "teams/{$this->currentTeam}/emojis", [
            'json' => [
                'emoji' => $data,
            ],
        ]);
    }

    /**
     * @param $code
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteEmoji($code)
    {
        return $this->httpClient->request('DELETE', "teams/{$this->currentTeam}/emojis/{$code}");
    }

    private function getCurrentTeamUrl($path = '')
    {
        return "teams/{$this->currentTeam}/$path";
    }
}
