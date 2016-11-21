<?php

namespace Http;

class HttpRequest implements Request
{
    protected $getParameters;
    protected $postParameters;
    protected $server;
    protected $files;
    protected $cookies;
    protected $inputStream;

    public function __construct(
        array $get,
        array $post,
        array $cookies,
        array $files,
        array $server,
        $inputStream = ''
    ) {
        $this->getParameters = $get;
        $this->postParameters = $post;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
        $this->inputStream = $inputStream;
    }

    /** {@inheritdoc} */
    public function getParameter($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }

        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }

        return $defaultValue;
    }

    /** {@inheritdoc} */
    public function getQueryParameter($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }

        return $defaultValue;
    }

    /** {@inheritdoc} */
    public function getBodyParameter($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }

        return $defaultValue;
    }

    /** {@inheritdoc} */
    public function getFile($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->files)) {
            return $this->files[$key];
        }

        return $defaultValue;
    }

    /** {@inheritdoc} */
    public function getCookie($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->cookies)) {
            return $this->cookies[$key];
        }

        return $defaultValue;
    }

    /** {@inheritdoc} */
    public function getParameters()
    {
        return array_merge($this->getParameters, $this->postParameters);
    }

    /** {@inheritdoc} */
    public function getQueryParameters()
    {
        return $this->getParameters;
    }

    /** {@inheritdoc} */
    public function getBodyParameters()
    {
        return $this->postParameters;
    }

    /** {@inheritdoc} */
    public function getRawBody()
    {
        return $this->inputStream;
    }

    /** {@inheritdoc} */
    public function getCookies()
    {
        return $this->cookies;
    }

    /** {@inheritdoc} */
    public function getFiles()
    {
        return $this->files;
    }

    /** {@inheritdoc} */
    public function getUri()
    {
        return $this->getServerVariable('REQUEST_URI');
    }

    /** {@inheritdoc} */
    public function getPath()
    {
        return strtok($this->getServerVariable('REQUEST_URI'), '?');
    }

    /** {@inheritdoc} */
    public function getRelativePath()
    {
        return substr($this->getPath(), strlen(dirname($this->getServerVariable('PHP_SELF'))));
    }

    /** {@inheritdoc} */
    public function getMethod()
    {
        return $this->getServerVariable('REQUEST_METHOD');
    }

    /** {@inheritdoc} */
    public function getHeader($header)
    {
        try {
            $header = str_replace('-', '_', strtoupper($header));
            return $this->getServerVariable('HTTP_' . $header);
        } catch (MissingRequestMetaVariableException $e) {
            return null;
        }
    }

    /** {@inheritdoc} */
    public function getHttpAccept()
    {
        return $this->getHeader('Accept');
    }

    /** {@inheritdoc} */
    public function getReferer()
    {
        // may the future fix the typo
        return $this->getHeader('Referer') ?: $this->getHeader('Referrer');
    }

    /** {@inheritdoc} */
    public function getUserAgent()
    {
        return $this->getHeader('User-Agent');
    }

    /** {@inheritdoc} */
    public function getIpAddress()
    {
        $client  = $this->getHeader('Client-Ip');
        $forward = $this->getHeader('X-Forwarded-For');

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            return $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            return $forward;
        } else {
            return $this->getServerVariable('REMOTE_ADDR');
        }
    }

    /** {@inheritdoc} */
    public function isSecure()
    {
        return (array_key_exists('HTTPS', $this->server)
            && $this->server['HTTPS'] !== 'off'
        );
    }

    /** {@inheritdoc} */
    public function getQueryString()
    {
        return $this->getServerVariable('QUERY_STRING');
    }

    private function getServerVariable($key)
    {
        if (!array_key_exists($key, $this->server)) {
            throw new MissingRequestMetaVariableException($key);
        }

        return $this->server[$key];
    }
}
