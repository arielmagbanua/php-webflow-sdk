![Tests / Lint](https://github.com/arielmagbanua/php-webflow-api/actions/workflows/tests.yml/badge.svg)

# php-webflow-api

PHP SDK for the Webflow Data API

# Authentication

If you are not using a workspace or site token, you can use the [OAuth](src/Auth/OAuth.php) class to retrieve an access token.

```php
// include the vendor autoload
require_once __DIR__ . '/../vendor/autoload.php';

use ArielMagbanua\PhpWebflowApi\Auth\OAuth;
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

use ArielMagbanua\PhpWebflowApi\Versions\V2\CollectionItems\LiveCollection;
use ArielMagbanua\PhpWebflowApi\Versions\V2\CollectionItems\StagedCollection;
use ArielMagbanua\PhpWebflowApi\Versions\V2\Authorization\Token;

// retrieved via OAuth or this can be a provided workspace or site access token
$accessToken = 'access_token';

$liveCollection = new LiveCollection(
    accessToken: $accessToken,
    collectionId: 'live_collection_id' // use the correct collection id from CMS
);
$stagedCollection = new StagedCollection(
    accessToken: $accessToken,
    collectionId: 'staged_collection_id'
);
$tokenInfo = new Token(
    accessToken: $accessToken
);

// information about the Authorized User
$tokenInfo->getUserInfo();

// information about the authorization token
$tokenInfo->getInfo();

// retrieve live collection items
$liveItems = $liveCollection->listItems();

// retrieve staged collection items
$stagedItems = $stagedCollection->listItems();
```
