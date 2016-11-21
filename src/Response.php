<?php

namespace Http;

interface Response
{
    /**
     * Sets the HTTP status code.
     *
     * @param  integer $statusCode
     * @param  string  $statusText (optional)
     * @return void
     */
    public function setStatusCode($statusCode, $statusText = null);

    /**
     * Returns the HTTP status code
     * @return int
     */
    public function getStatusCode();

    /**
     * Adds a header with the given name.
     *
     * @param  string $name
     * @param  string $value
     * @return void
     */
    public function addHeader($name, $value);

    /**
     * Sets a new header for the given name.
     *
     * Replaces all headers with the same names.
     *
     * @param  string $name
     * @param  string $value
     * @return void
     */
    public function setHeader($name, $value);

    /**
     * Returns an array with the HTTP headers.
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Adds a new cookie.
     *
     * @param  Cookie $cookie
     * @return void
     */
    public function addCookie(Cookie $cookie);

    /**
     * Deletes a cookie.
     *
     * @param  Cookie $cookie
     * @return void
     */
    public function deleteCookie(Cookie $cookie);

    /**
     * Sets the body content.
     *
     * @param  string $content
     * @return void
     */
    public function setContent($content);

    /**
     * Returns the body content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Sets the headers for a redirect.
     *
     * @param  string $url
     * @param  bool   $permanent
     */
    public function redirect($url, $permanent);

    /**
     * Sends the headers and content
     *
     * @codeCoverageIgnore This function can not be tested because it uses native php functions
     * @return void
     */
    public function send();
}
