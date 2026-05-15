![Tests / Lint](https://github.com/arielmagbanua/webflow-php-sdk/actions/workflows/tests.yml/badge.svg)
[![Packagist Version](https://img.shields.io/packagist/v/arielmagbanua/webflow-php-sdk)](https://packagist.org/packages/arielmagbanua/webflow-php-sdk)
[![Packagist Downloads](https://img.shields.io/packagist/dt/arielmagbanua/webflow-php-sdk?label=packagist%20downloads)](https://packagist.org/packages/arielmagbanua/webflow-php-sdk)
[![Packagist Stars](https://img.shields.io/packagist/stars/arielmagbanua/webflow-php-sdk)](https://packagist.org/packages/arielmagbanua/webflow-php-sdk)

# PHP Webflow SDK

PHP SDK for the Webflow Data API

# Authentication

If you are not using a workspace or site token, you can use the [OAuth](/src/DataApi/Versions/V2/Authentication/OAuth.php) class to retrieve an access token.

```php
// include the vendor autoload
require_once __DIR__ . '/../vendor/autoload.php';

use ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Authentication\OAuth;
use Dotenv\Dotenv;

// load environment variable if API credentials were configured in the environment
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// API credentials
$clientId = $_ENV['WEBFLOW_CLIENT_ID'] ?? null;
$clientSecret = $_ENV['WEBFLOW_CLIENT_SECRET'] ?? null;
$state = $_ENV['WEBFLOW_DEFAULT_STATE'] ?? null;
$redirectUri = $_ENV['WEBFLOW_REDIRECT_URI'] ?? null;

// create OAuth object
$oauth = new OAuth(
    clientId: $clientId,
    clientSecret: $clientSecret,
    state: $state,
    redirectUri: $redirectUri,
    scopes: [
        'cms:read',
        'cms:write',
        'authorized_user:read',
    ]
);

// generate authorization url use the URL to authenticate the client
$authorizationUrl = $oauth->getAuthorizationUrl();
```

After successful client authentication, the client will be redirected to the provided redirect url where you can retrieve the authorization `code` from the query part of the redirect url. Once you retrieve the `code`, you should be able now to exchange it for access token.

```php
// exchange the authorization code with access token
$tokenObject = $oauth->requestAccessToken($code);

// get the access token value
$accessToken = $tokenObject->getAccessToken();
```

# CMS and Data API Resources Usage

Once you secure your access token via OAuth or if you have already workspace or site token. You can now push or pull data from CMS or other Data API resources.

```php
// include the vendor autoload
require_once __DIR__ . '/../vendor/autoload.php';

use ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Cms\CollectionItems\LiveItems;
use ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Cms\CollectionItems\StagedItems;
use ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Token\Info;

// retrieved via OAuth or this can be a provided workspace or site access token
$accessToken = 'access_token';

$liveItems = new LiveItems(
    accessToken: $accessToken,
    collectionId: 'live_collection_id' // use the correct collection id from CMS
);
$stagedItems = new StagedItems(
    accessToken: $accessToken,
    collectionId: 'staged_collection_id'
);
$tokenInfo = new Info(
    accessToken: $accessToken
);

// information about the Authorized User
$tokenInfo->getAuthorizationUserInfo();

// information about the authorization token
$tokenInfo->getAuthorizationInfo();

// retrieve live collection items
$liveItems = $liveItems->listItems();

// retrieve staged collection items
$stagedItems = $stagedItems->listItems();
```
