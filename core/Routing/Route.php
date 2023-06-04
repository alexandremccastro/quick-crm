<?php

namespace Core\Routing;

use Core\Http\HttpStatus;
use Core\Http\Response;
use Core\Routing\URI;
use Exception;

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
    public static function dispatch(string $path): Response
    {
        $currentMethod = server()->getRequestMethod();

        $results = array_filter(self::$uris, function (URI $uri) use ($path, $currentMethod) {
            if ($uri->match($path) && $uri->getMethod() == $currentMethod) return $uri;
        });

        $uri = current($results);


        if ($uri) {
            $response = $uri->execute($path);
            return $response->send();
        } else if (self::isPublicPath($path)) {
            $response = self::serveFile($path);
            return $response->send();
        } else {
            return view('errors.404')
                ->withStatus(HttpStatus::NOT_FOUND)->send();
        }
    }

    /**
     * Checks if the URI is for public path
     * 
     * @param $path The path to be verified
     * 
     * @return bool True if is the public path, otherwise false
     */
    public static function isPublicPath($path)
    {
        return preg_match("/^\/public/", $path);
    }

    /**
     * Displays the content of a file in public dir
     * 
     * @param $path The path of the file
     */
    public static function serveFile(string $path): Response
    {
        $filePath = implode(DIRECTORY_SEPARATOR, [server()->getDocumentRoot(), $path]);

        if (file_exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);

            $mimeTypes = [
                'txt' => 'text/plain',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'pdf' => 'application/pdf',
            ];

            $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

            return response()->withHeaders(["Content-Type: $contentType"])
                ->setContent(file_get_contents($filePath));
        }
    }
}
