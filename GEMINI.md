# Gemini Context: php-webflow-api

This file provides context and instructions for AI interactions within this repository.

## Project Overview

`php-webflow-api` is a PHP SDK for the Webflow Data API. It is designed to provide an easy-to-use interface for interacting with Webflow's data services.

- **Main Technologies:** PHP 8.1+, Guzzle HTTP Client.
- **Architecture:** PSR-4 compliant library structure.
- **Status:** In development (some modules like `Collections` and `Sites` are currently placeholders).

## Building and Running

The project uses Composer for dependency management and task execution. A `makefile` is also provided for convenience.

### Key Commands

- **Install Dependencies:**
  ```bash
  composer install
  ```

- **Run Tests:**
  ```bash
  composer test
  # OR
  make test
  ```

- **Static Analysis (PHPStan):**
  ```bash
  composer phpstan
  ```

- **Code Formatting (php-cs-fixer):**
  ```bash
  # Dry run
  composer check
  
  # Apply fixes
  composer format
  # OR
  make clean
  ```

## Development Conventions

- **Strict Typing:** All PHP files must start with `declare(strict_types=1);`.
- **Coding Style:** Adheres to PSR-12 (enforced by `php-cs-fixer`).
- **Modern PHP:** Utilizes PHP 8.0+ features like constructor property promotion and named arguments.
- **Namespacing:** 
  - Source: `ArielMagbanua\PhpWebflowApi\` (mapped to `src/`)
  - Tests: `ArielMagbanua\PhpWebflowApi\Tests\` (mapped to `tests/`)
- **Testing:** Comprehensive test coverage using PHPUnit is expected for all new features.
- **Static Analysis:** PHPStan level 5 is the current target for analysis.
