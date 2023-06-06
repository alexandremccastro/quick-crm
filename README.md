# Quick CRM

A simple customer management system

## How to install

First, you need a .env file to setup the database connection and other app features, for this run:

```sh
cp .env.example .env
```

And than configure your database credentials.

To start this project you need to use docker compose to start the database container.

```sh
docker compose up -d
```

When the database container is up you need to migrate the app database

## Run Composer

Run composer to creates the autload for project files

```sh
composer install
```

## Commands

This project has a set of commands to helper the developer

### Run Migration

Be sure to have the database correctly configure before run this command

```sh
php command migrate
```

### Serve The app

Starts the application in development mode using php default server

```sh
php command serve
```
