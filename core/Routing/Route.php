<?php

namespace Core\Routing;

use Core\Routing\URI;

abstract class Route
{
    private static array $uris = [];

    public static function post(string $path, array $action)
    {
        self::registerURI($path, $action, Method::POST);
    }

    public static function get(string $path, mixed $action)
    {
        self::registerURI($path, $action, Method::GET);
    }

    public static function put(string $path, mixed $action)
    {
        self::registerURI($path, $action, Method::PUT);
    }

    public static function patch(string $path, mixed $action)
    {
        self::registerURI($path, $action, Method::PATCH);
    }

    public static function delete(string $path, mixed $action)
    {
        self::registerURI($path, $action, Method::DELETE);
    }

    /**
     * Creates a new URI instance and stores in local variable
     * 
     * @param $path The path of the URI
     * @param $action The action the will execute when user hits this URI
     * @param $method The request method allowed to access this path
     */
    private static function registerURI(string $path, mixed $action, Method $requestMethod)
    {
        if (is_array($action)) {
            [$clazz, $method] = $action;

            self::$uris[] = new URI($path, $clazz, $method, $requestMethod);
        } else {
            self::$uris[] = new URI($path, null, $action, $requestMethod);
        }
    }


    /**
     * Attempts to execute a given URI path
     * 
     * @param $path The path that will be loaded
     */
    public static function dispatch(string $path)
    {
        $currentMethod = server()->requestMethod();

        $results = array_filter(self::$uris, function (URI $uri) use ($path, $currentMethod) {
            if ($uri->match($path) && $uri->getMethod() == $currentMethod) return $uri;
        });

        $uri = current($results);

        if ($uri) $uri->execute($path);
        else throw new \Exception('Not found.', 404);
    }
}
