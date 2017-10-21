<?php
namespace Polidog\Esa\Exception;

use GuzzleHttp\Exception\ClientException;

class ApiErrorException extends \RuntimeException
{
    /**
     * @var string
     */
    private $apiMethodName;

    /**
     * @var array
     */
    private $args;

    /**
     * @return string
     */
    public function getApiMethodName()
    {
        return $this->apiMethodName;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param \Exception $e
     * @param            $name
     * @param array      $args
     * @return ApiErrorException
     */
    public static function newException(\Exception $e, $name, array $args)
    {
        $self = new self(sprintf("Api method error: %s", $name), $e->getCode(), $e);
        $self->apiMethodName = $name;
        $self->args = $args;
        return $self;
    }

}
