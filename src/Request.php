<?php

namespace Http;

interface Request
{
    /**
     * Returns a parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getParameter($key, $defaultValue = null);

    /**
     * Returns a query parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getQueryParameter($key, $defaultValue = null);

    /**
     * Returns a body parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getBodyParameter($key, $defaultValue = null);

    /**
     * Returns a file value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getFile($key, $defaultValue = null);

    /**
     * Returns a cookie value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getCookie($key, $defaultValue = null);

    /**
     * Returns all parameters.
     *
     * @return array
     */
    public function getParameters();

    /**
     * Returns all query parameters.
     *
     * @return array
     */
    public function getQueryParameters();

    /**
     * Returns all body parameters.
     *
     * @return array
     */
    public function getBodyParameters();

    /**
     * Returns raw values from the read-only stream that allows you to read raw data from the request body.
     *
     * @return string
     */
    public function getRawBody();

    /**
     * Returns a Cookie Iterator.
     *
     * @return array
     */
    public function getCookies();

    /**
     * Returns a File Iterator.
     *
     * @return array
     */
    public function getFiles();

    /**
     * The URI which was given in order to access this page
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getUri();

    /**
     * Return just the path
     *
     * @return string
     */
    public function getPath();

    /**
     * Get path relative to executed script
     *
     * @return string
     */
    public function getRelativePath();

    /**
     * Which request method was used to access the page;
     * i.e. 'GET', 'HEAD', 'POST', 'PUT'.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getMethod();

    /**
     * Returns the scheme used to request the page;
     * i.e. 'http', 'https'
     *
     * @return string
     */
    public function getScheme();

    /**
     * Get the variable from $header.
     *
     * @param string $header
     * @return string|null
     */
    public function getHeader($header);

    /**
     * Contents of the Accept: header from the current request, if there is one.
     *
     * @return string
     * @deprecated use getHeader instead
     */
    public function getHttpAccept();

    /**
     * The address of the page (if any) which referred the user agent to the
     * current page.
     *
     * @return string
     * @deprecated use getHeader instead
     */
    public function getReferer();

    /**
     * Content of the User-Agent header from the request, if there is one.
     *
     * @return string
     * @deprecated use getHeader instead
     */
    public function getUserAgent();

    /**
     * The IP address from which the user is viewing the current page.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getIpAddress();

    /**
     * Checks to see whether the current request is using HTTPS.
     *
     * @return boolean
     */
    public function isSecure();

    /**
     * The query string, if any, via which the page was accessed.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getQueryString();
}
