<?php

namespace Polidog\Esa\Exception;

class ClientException extends \RuntimeException
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $params;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param \Exception $e
     * @param            $method
     * @param            $path
     * @param array      $params
     *
     * @return ClientException
     */
    public static function newException(\Exception $e, $method, $path, array $params)
    {
        $self = new self(sprintf('Api method error: %s : %s', $method, $path), $e->getCode(), $e);
        $self->method = $method;
        $self->path = $path;
        $self->params = $params;

        return $self;
    }
}
