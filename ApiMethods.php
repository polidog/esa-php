<?php
namespace Polidog\Esa;
use GuzzleHttp\ClientInterface;

/**
 * Class ApiMethods
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function teams()
    {
        return $this->httpClient->request('GET','teams');
    }

    /**
     * @param null $name
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function team($name = null)
    {
        return $this->httpClient->request('GET',"teams/{$name}");
    }

    /**
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function posts(array $params = [])
    {
        return $this->httpClient->request('GET',"teams/{$this->currentTeam}/posts",[
            'query' => $params
        ]);
    }

    /**
     * @param $number
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($number)
    {
        return $this->httpClient->request('GET',"teams/{$this->currentTeam}/posts/{$number}");
    }

    /**
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createPost($data)
    {
        return $this->httpClient->request('POST',"teams/{$this->currentTeam}/posts",[
            'json' => [
                'post' => $data
            ]
        ]);
    }

    /**
     * @param $number
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updatePost($number, $data)
    {
        return $this->httpClient->request('PATCH',"teams/{$this->currentTeam}/posts/{$number}",[
            'json' => [
                'post' => $data
            ]
        ]);
    }

    /**
     * @param $number
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deletePost($number)
    {
        return $this->httpClient->request('DELETE',"teams/{$this->currentTeam}/posts/{$number}");
    }

    /**
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function emojis(array $params = [])
    {
        return $this->httpClient->request('GET', "teams/{$this->currentTeam}/emojis",[
            'query' => $params
        ]);
    }

    /**
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createEmoji($data)
    {
        return $this->httpClient->request('POST',"teams/{$this->currentTeam}/emojis",[
            'json' => [
                'emoji' => $data
            ]
        ]);
    }

    /**
     * @param $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteEmoji($code)
    {
        return $this->httpClient->request('DELETE',"teams/{$this->currentTeam}/emojis/{$code}");
    }
}
