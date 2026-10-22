<?php
/**
 * Application Bootstrap & Router
 */

class App {
    private static array $routes = [];

    public static function get(string $path, $handler): void {
        self::addRoute('GET', $path, $handler);
    }

    public static function post(string $path, $handler): void {
        self::addRoute('POST', $path, $handler);
    }

    private static function addRoute(string $method, string $path, $handler): void {
        self::$routes[] = [
            'method'  => $method,
            'path'    => '/' . trim($path, '/'),
            'handler' => $handler
        ];
    }

    public static function run(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        // Dapatkan request URI
        $uri = $_GET['r'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        
        // Hilangkan subfolder script jika ada
        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }

        $uri = '/' . trim($uri, '/');
        // Bersihkan nama file seperti index.php
        if ($uri === '/index.php') {
            $uri = '/';
        }

        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) continue;

            // Pola regex untuk route dinamis (misal /berita/{slug} atau /admin/posts/edit/{id})
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                self::dispatch($route['handler'], $params);
                return;
            }
        }

        // Jika tidak ada route cocok: 404 Not Found
        http_response_code(404);
        require_once ROOT_PATH . '/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->notFound();
    }

    private static function dispatch($handler, array $params = []): void {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_string($handler)) {
            [$controllerName, $action] = explode('@', $handler);

            // Cek jika controller di subfolder Admin
            if (strpos($controllerName, 'Admin/') === 0) {
                $filePath = ROOT_PATH . '/controllers/' . $controllerName . '.php';
                $className = basename($controllerName);
            } else {
                $filePath = ROOT_PATH . '/controllers/' . $controllerName . '.php';
                $className = $controllerName;
            }

            if (!file_exists($filePath)) {
                die("Controller file not found: {$filePath}");
            }

            require_once $filePath;
            if (!class_exists($className)) {
                if (class_exists('Admin' . $className)) {
                    $className = 'Admin' . $className;
                } else {
                    die("Controller class [{$className}] not found.");
                }
            }

            $instance = new $className();
            if (!method_exists($instance, $action)) {
                die("Method [{$action}] not found on controller [{$className}].");
            }

            call_user_func_array([$instance, $action], $params);
        }
    }
}
