# Project: php-webflow-sdk

PHP SDK for the Webflow Data API.

## Project Overview

This project provides a structured and type-safe PHP interface for interacting with the Webflow Data API. It is designed to be extensible, supporting multiple API versions, with a current focus on V2.

### Core Technologies
- **Language:** PHP 8.1+
- **HTTP Client:** GuzzleHttp (^7.10)
- **Testing:** PHPUnit (^10.5)
- **Static Analysis:** PHPStan (^2.1)
- **Coding Standard:** PHP-CS-Fixer (^3.95)

### Architecture
- `ArielMagbanua\PhpWebflowApi\BaseApi`: Abstract base class that manages the Guzzle HTTP client and basic request handling.
- `ArielMagbanua\PhpWebflowApi\DataApi\Api`: Extends `BaseApi` to handle authentication (Bearer token) and versioning prefixes for Data API requests.
- `ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2`: Contains the V2 implementation of various Webflow API endpoints (e.g., Authentication, CollectionItems, Sites).

## Building and Running

### Prerequisites
- PHP 8.1 or higher
- Composer

### Key Commands
- `composer install`: Install dependencies.
- `composer test`: Run the test suite.
- `composer format`: Automatically fix code style issues using PHP-CS-Fixer.
- `composer check`: Check code style without making changes.
- `composer phpstan`: Run static analysis.
- `make test`: Runs `check`, `phpstan`, and `test` in sequence.

## Development Conventions

- **Strict Typing:** All files must include `declare(strict_types=1);`.
- **Namespacing:** Follows PSR-4 with the root namespace `ArielMagbanua\PhpWebflowApi\`.
- **Coding Style:** Follows PSR-12 (enforced by PHP-CS-Fixer).
- **Testing:** 
    - Unit tests are located in `tests/Unit`.
    - Payload mocks for testing are stored in `tests/payloads/`.
- **Extending the SDK:** To add new API endpoints, create a new class in the appropriate `src/DataApi/Versions/{Version}/{Module}` directory that extends `DataApi\Api`.
