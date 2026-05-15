# PHP Webflow SDK

PHP SDK for the Webflow Data API (V2), designed for ease of use and extensibility.

## Project Overview

- **Purpose:** Provide a PHP wrapper for interacting with Webflow's Data API.
- **Technologies:** 
  - PHP >= 8.1
  - [GuzzleHttp](https://docs.guzzlephp.org/en/stable/) for HTTP requests.
  - [PHPUnit](https://phpunit.de/) for testing.
  - [PHP-CS-Fixer](https://cs.symfony.com/) for coding standards.
  - [PHPStan](https://phpstan.org/) for static analysis.

## Architecture

The SDK follows a layered approach to support multiple API versions and resources:

1. **`BaseApi`**: The root abstract class that initializes the Guzzle client and provides a generic `sendRequest` method.
2. **`DataApi\Api`**: Extends `BaseApi` to handle common Data API requirements like access tokens and API versioning.
3. **Contracts**: Located in `src/DataApi/{Resource}/Contracts/`, these abstract classes define the expected methods for a specific Webflow resource (e.g., `Sites`, `Collections`, `CollectionItems`).
4. **Versions**: Located in `src/DataApi/Versions/V2/`, these concrete classes implement the contracts for a specific API version.
5. **Authentication**: `OAuth.php` handles the OAuth 2.0 flow to retrieve access tokens.

## Building and Running

### Key Commands

- **Install Dependencies:** `composer install`
- **Run Tests:** `composer test` or `make test` (the latter also runs linting and static analysis)
- **Code Linting (Check):** `composer check`
- **Auto-format Code:** `composer format` or `make clean`
- **Static Analysis:** `composer phpstan`

## Development Conventions

- **Strict Typing:** All PHP files MUST include `declare(strict_types=1);`.
- **PSR-4 Autoloading:** Follow the PSR-4 namespace conventions as defined in `composer.json`.
- **Modern PHP:** Leverage PHP 8.1+ features such as constructor property promotion and typed properties.
- **Resource Implementation:** When adding support for a new resource:
  1. Define an abstract contract in `src/DataApi/{Resource}/Contracts/`.
  2. Implement the concrete class in `src/DataApi/Versions/V2/`.
- **Testing:** 
  - All new features or bug fixes MUST include corresponding unit tests in the `tests/Unit` directory.
  - Use JSON payloads in `tests/payloads` for mocking API responses.
- **Coding Style:** Adhere to the rules defined in `.php-cs-fixer.dist.php`. Run `composer format` before committing.
