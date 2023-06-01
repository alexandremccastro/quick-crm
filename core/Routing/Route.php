<?php

namespace Core\Routing;

use Core\Routing\URI;

abstract class Route
{
    private static array $uris = [];

    public static function post(string $uri, array $action)
    {
        [$clazz, $method] = $action;

        self::$uris[] = new URI($uri, $clazz, $method, Method::POST);
    }

    public static function get(string $uri, array $action)
    {
        [$clazz, $method] = $action;

        self::$uris[] = new URI($uri, $clazz, $method, Method::GET);
    }

    public static function put(string $uri, array $action)
    {
        [$clazz, $method] = $action;

        self::$uris[] = new URI($uri, $clazz, $method, Method::PUT);
    }

    public static function patch(string $uri, array $action)
    {
        [$clazz, $method] = $action;

        self::$uris[] = new URI($uri, $clazz, $method, Method::PATCH);
    }

    public static function delete(string $uri, array $action)
    {
        [$clazz, $method] = $action;

        self::$uris[] = new URI($uri, $clazz, $method, Method::DELETE);
    }


    /**
     * Attempts to execute a given URI path
     * 
     * @param $path The path that will be loaded
     */
    public static function dispatch(string $path)
    {
        $results = array_filter(self::$uris, function (URI $uri) use ($path) {
            if ($uri->match($path)) return $uri;
        });

        $uri = current($results);

        if ($uri) $uri->execute($path);
        else throw new \Exception('Not found.', 404);
    }
}
