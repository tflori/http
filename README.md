## Http Component

[![Build Status](https://travis-ci.org/tflori/http.svg?branch=master)](https://travis-ci.org/tflori/http) 
[![Coverage Status](https://coveralls.io/repos/github/tflori/http/badge.svg?branch=master)](https://coveralls.io/github/tflori/http?branch=master)
[![Latest Stable Version](https://poser.pugx.org/tflori/http/v/stable.svg)](https://packagist.org/packages/tflori/http) 
[![Total Downloads](https://poser.pugx.org/tflori/http/downloads.svg)](https://packagist.org/packages/tflori/http) 
[![License](https://poser.pugx.org/tflori/http/license.svg)](https://packagist.org/packages/tflori/http)

## Installation

You can use composer to install this component: 
```
composer require tflori/http
```

## Basic Usage

### Request

The Request class provides an object oriented wrapper around the PHP superglobals. This makes it possible to inject it
as a dependency into any of your classes that require it.


```php
use Http\HttpRequest;

$request = new HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, file_get_contents('php://input'));
// equals to:
$request = HttpRequest::createFromGlobals();
```

Now you can use the following methods on the `$request` object:
```php
$request->getParameter($key, $defaultValue = null);
$request->getFile($key, $defaultValue = null);
$request->getCookie($key, $defaultValue = null);
$request->getParameters();
$request->getQueryParameters();
$request->getBodyParameters();
$request->getRawBody();
$request->getCookies();
$request->getFiles();
$request->getMethod();
$request->getScheme();
$request->getHttpAccept();
$request->getReferer();
$request->getUserAgent();
$request->getIpAddress();
$request->isSecure();
$request->getQueryString();
```

Please note that both GET and POST parameters are merged together and accessible with `getParameter`.

### Response

The `HttpResponse` object is the data holder for the HTTP response. It has no constructor dependencies and can be
instantiated with just:

```php
use Http\HttpResponse;

$response =  new HttpResponse;
```

The response can be modified with following methods:

```php
$response->setStatusCode($statusCode, $statusText = null);
$response->addHeader($name, $value);
$response->setHeader($name, $value);
$response->addCookie(Cookie $cookie);
$response->deleteCookie(Cookie $cookie);
$response->setContent($content);
$response->redirect($url);
```

If you don't supply a status text with `setStatusCode` then an appropriate default status text will be selected for the
HTTP status code if available.

`addHeader` adds a new header value without overwriting existing values, `setHeader` will overwrite an existing value.

The `redirect` method will set the status code and text for a 301 redirect.

`deleteCookie` will set the cookie content to nothing and put the expiration in the past.

The following two methods are available to get the current data in the response:

```php
$response->getHeaders();
$response->getContent();
```

To send the response use the following method:

```php
$response->send();
```

> make sure not to send the response twice as you will get an error message.

### Cookies

To avoid `new` calls in your classes and to have the ability to set default cookie settings for you application, there
is a `CookieBuilder` class that you can use to create your cookie objects. It has the following methods available:

```php
$cookieBuilder->setDefaultDomain($domain); // defaults to NULL
$cookieBuilder->setDefaultPath($path); // defaults to '/'
$cookieBuilder->setDefaultSecure($secure); // defaults to TRUE
$cookieBuilder->setDefaultHttpOnly($httpOnly); // defaults to TRUE
$cookieBuilder->build($name, $value); // returns the cookie object
```

You can use the following methods to manipulate an existing cookie:

```php
$cookie->setValue($value);
$cookie->setMaxAge($seconds);
$cookie->setDomain($domain);
$cookie->setPath($path);
$cookie->setSecure($secure);
$cookie->setHttpOnly($httpOnly);
```

The cookie object can the be used with the `HttpResponse` methods `addCookie` and `deleteCookie`. 

### Example

```php
<?php

use Http\HttpRequest;
use Http\HttpResponse;
use Http\CookieBuilder;

$loader = require_once __DIR__ . '/vendor/autoload.php';

$cookieBuilder = new CookieBuilder();

// Disable the secure flag because this is only an example
$cookieBuilder->setDefaultSecure(false);

$request = HttpRequest::createFromGlobals();
$response = new HttpResponse();

$content = '<h1>Hello World</h1>';
$content .= $request->getCookie('TestCookie', 'Cookie is not set.');

if ($request->getParameter('setCookie') === 'true') {
    $cookie = $cookieBuilder->build('TestCookie', 'Cookie is set.');
    $response->addCookie($cookie);
}

$response->setContent($content);

$response->send();
```
