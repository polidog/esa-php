<?php

declare(strict_types=1);

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

    public function __construct(ClientInterface $client, string $currentTeam)
    {
        $this->client = $client;
        $this->currentTeam = $currentTeam;
    }

    public function user(array $params = []): array
    {
        return $this->client->request('GET', 'user', [
            'query' => $params,
        ]);
    }

    public function teams(): array
    {
        return $this->client->request('GET', 'teams');
    }

    public function team(string $name = null): array
    {
        return $this->client->request('GET', "teams/{$name}");
    }

    public function stats(): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('stats'));
    }

    public function members(): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('members'));
    }

    public function posts(array $params = []): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('posts'), [
            'query' => $params,
        ]);
    }

    public function post(int $number): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$number}"));
    }

    public function createPost(array $data): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('posts'), [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    public function updatePost(int $number, array $data): array
    {
        return $this->client->request('PATCH', $this->getCurrentTeamUrl("posts/{$number}"), [
            'json' => [
                'post' => $data,
            ],
        ]);
    }

    public function deletePost(int $number): array
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$number}"));
    }

    public function comments(int $number = null, array $params = []): array
    {
        if (null === $number) {
            return $this->client->request('GET', $this->getCurrentTeamUrl('comments'), [
                'query' => $params,
            ]);
        }

        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$number}/comments"), [
            'query' => $params,
        ]);
    }

    public function comment(int $commentId, array $params = []): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("comments/{$commentId}"), [
            'query' => $params,
        ]);
    }

    public function createComment(int $postNumber, array $data): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/comments"), [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    public function updateComment(int $commentId, array $data): array
    {
        return $this->client->request('PATCH', $this->getCurrentTeamUrl("comments/{$commentId}"), [
            'json' => [
                'comment' => $data,
            ],
        ]);
    }

    public function deleteComment(int $commentId): array
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("comments/{$commentId}"));
    }

    public function createSharing(int $postNumber): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    public function deleteSharing(int $postNumber): array
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/sharing"));
    }

    public function postStargazers(int $postNumber, array $params = []): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/stargazers"), [
            'query' => $params,
        ]);
    }

    public function addPostStar(int $postNumber, array $params = []): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/star"), [
            'json' => $params,
        ]);
    }

    public function deletePostStar(int $postNumber): array
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/star"));
    }

    public function commentStargazers(int $commentId, array $params = []): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("comments/{$commentId}/stargazers"), [
            'query' => $params,
        ]);
    }

    public function addCommentStar(int $commentId, array $params = []): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("comments/{$commentId}/star"), [
            'json' => $params,
        ]);
    }

    public function deleteCommentStar(int $commentId): array
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("comments/{$commentId}/star"));
    }

    public function watchers(int $postNumber, array $params = []): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl("posts/{$postNumber}/watchers"), [
            'query' => $params,
        ]);
    }

    public function addWatch(int $postNumber): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl("posts/{$postNumber}/watch"));
    }

    public function deleteWatch(int $postNumber): array
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("posts/{$postNumber}/watch"));
    }

    public function categories(): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('categories'));
    }

    public function batchMoveCategory(array $params = []): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('categories/batch_move'), [
            'json' => $params,
        ]);
    }

    public function tags(): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('tags'));
    }

    public function invitation(): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('invitation'));
    }

    public function regenerateInvitation(): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('invitation_regenerator'));
    }

    public function pendingInvitations(array $params = []): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('invitations'), [
            'query' => $params,
        ]);
    }

    public function sendInvitation(array $emails): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('invitations'), [
            'json' => [
                'members' => ['emails' => $emails],
            ],
        ]);
    }

    public function cancelInvitation(string $code): array
    {
        return $this->client->request('DELETE', $this->getCurrentTeamUrl("invitations/{$code}"));
    }

    public function emojis(array $params = []): array
    {
        return $this->client->request('GET', $this->getCurrentTeamUrl('emojis'), [
            'query' => $params,
        ]);
    }

    public function createEmoji(array $data): array
    {
        return $this->client->request('POST', $this->getCurrentTeamUrl('emojis'), [
            'json' => [
                'emoji' => $data,
            ],
        ]);
    }

    public function deleteEmoji(string $code): array
    {
        return $this->client->request('DELETE', "teams/{$this->currentTeam}/emojis/{$code}");
    }

    public static function factory(string $accessToken, string $currentTeam): self
    {
        $client = Client::factory($accessToken);

        return new self($client, $currentTeam);
    }

    private function getCurrentTeamUrl(string $path = ''): string
    {
        return "teams/{$this->currentTeam}/$path";
    }
}
