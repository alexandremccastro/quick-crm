<?php

namespace Core\Routing;

use Core\Http\Response;
use Exception;

class URI
{
    private string $regex;

    public function __construct(
        private string $path,
        private mixed $clazz,
        private mixed $method,
        private Method $allowedMethod
    ) {
        $this->regex = $this->createRegex($path);
    }

    /**
     * Build a regex for a URI path
     * 
     * @param $path The path of the URI
     * 
     * @return string The URI regex
     */
    private function createRegex(string $path): string
    {
        $peaces = explode('/', $path);
        $regex  = [];

        foreach ($peaces as $peace) {
            if (preg_match('/^{([0-9a-zA-Z]+)}$/', $peace))
                $regex[] = '([0-9a-zA-Z]+)';
            else $regex[] = $peace;
        }

        $parsed = implode('\/', $regex);

        return "/^$parsed$/";
    }

    /**
     * Checks if the URI matches a given path
     * 
     * @param $path The path the will be verified
     * 
     * @return bool TRUE if maches, otherwise FALSE
     */
    public function match(string $path): bool
    {
        return preg_match($this->regex, $path);
    }

    /**
     * Gets the parameters of a given URI
     * 
     * @param $path The URI path
     * 
     * @return array The list of params in the URI
     */
    private function getParams(string $path): array
    {
        $peaces = explode('/', $this->path);
        $slices = explode('/', $path);
        $params  = [];

        foreach ($peaces as $index => $peace) {
            if (preg_match('/^{([0-9a-zA-Z]+)}$/', $peace))
                $params[] = $slices[$index];
        }

        return $params;
    }

    /**
     * Execute the action related to this URI
     * 
     * @param $path The URI path passed by the browser
     */
    public function execute(string $path): Response
    {
        try {
            $params = $this->getParams($path);

            if ($this->clazz) {
                $clazz = new $this->clazz();
                return call_user_func_array([$clazz, $this->method], $params);
            } else {
                return call_user_func($this->method, $params);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return Response::getInstance();
        }
    }

    /**
     * @return string The allowed method for this URI
     */
    public function getMethod(): string
    {
        return $this->allowedMethod->value();
    }
}
