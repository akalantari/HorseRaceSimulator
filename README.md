# Horse Race Simulator

A simple horse race simulator built upon CakePHP3 Framework

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar install`.

If Composer is installed globally, run

```bash
composer install
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Configuration

Import the `horserace_db.sql` to your MySQL server.
Read and edit `config/app.php` and setup the `'Datasources'` accordingly so that it can connect to the database that you have created
