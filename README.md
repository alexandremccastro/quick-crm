# Quick CRM

A simple customer management system

## How to install

First, you need a .env file to setup the database connection and other app features, for this run:

```sh
cp .env.example .env
```

And than configure your database credentials.

## Start with Docker

To start this project you need to use docker compose to start the database and all other services container.

```sh
docker compose up -d
```

After that you can access the app in **localhost** in the port specified in `.env`

## Commands

This project has a set of commands to helper the developer

### Run Composer

If you are in development mode you can run composer to creates the autload for project files

```sh
composer install
```

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
