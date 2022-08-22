# GitHub API (Pure PHP)

A simple OOP wrapper for GitHub API written with pure PHP contains console commands

Uses [GitHub API v3](http://developer.github.com/v3/) & supports [GitHub API v4](http://developer.github.com/v4). The object API (v3) is very similar to the RESTful API.

- [Features](#features)
- [Installation](#installation)
- [Requirements](#requirements)
- [Quick Start and Examples](#quick-start-and-examples)

## Features

* Light and fast thanks to lazy loading of API classes
* Extensively tested and documented
* Separated Console and RestFull API structure
* Follows MVC architecture
* Supports service locator and dependency injection
K
### Installation

Easy install PHP GitHub api using git command:

    git clone https://github.com/meygh/gitub-api.git
    
Via [Composer](https://getcomposer.org).

Run `composer require`

## Requirements

* PHP >= 8.1
* [PHP cURL class](https://github.com/php-curl-class/php-curl-class)



### Quick Start and Examples

You need to config Application to access your GitHub account.

You only need to put your `Personal Access Token` in config files:

* Console Config: `/app/config/console.php`

* Web Config: `/app/config/web.php`


## Console commands

List of all exists commands

```php
php run.php
```


List of all authenticated user's repositories

```php
php run.php user-repos [since:UNIX_TIMESTAMP]
```


Create a new repository For authenticated user

```php
php run.php create-repo name:YOUR-REPOSITORY-NAME
```


Delete a new repository from authenticated user

```php
php run.php del-repo repo:YOUR-REPOSITORY-NAME
```


## RESTful API


Get all authenticated user's repositories

Headers: `Content-Type: application/json`

Method: `GET`

Url: `http://YOUR_DOMAIN/repositories`


Optional Body Data

```json
{
 "user": "USER_NAME_TO_FILTER_RESULT"
}
 ```