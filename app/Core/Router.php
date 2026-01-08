<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $pattern, $handler): void
    {
        $this->add('GET', $pattern, $handler);
    }

    public function post(string $pattern, $handler): void
    {
        $this->add('POST', $pattern, $handler);
    }

    private function add(string $method, string $pattern, $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace('#\\{[a-zA-Z_]+\\}#', '([^/]+)', $route['pattern']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                $this->invoke($route['handler'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function invoke($handler, array $params): void
    {
        if (is_array($handler)) {
            $class = $handler[0];
            $method = $handler[1];
            $instance = new $class();
            $instance->$method(...$params);
            return;
        }

        if (is_callable($handler)) {
            $handler(...$params);
        }
    }
}
