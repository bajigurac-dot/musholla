<?php
/**
 * Base Controller
 */

abstract class Controller {
    protected function render(string $view, array $data = [], string $layout = 'main'): void {
        // Ekstrak data untuk view
        extract($data);

        // Ambil pengaturan website global untuk seluruh view
        $globalSettings = Setting::getAllAssoc();

        // Buffer tampilan view
        $viewFile = ROOT_PATH . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("View [{$view}] tidak ditemukan di {$viewFile}");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render dengan layout
        if ($layout) {
            $layoutFile = ROOT_PATH . '/views/layouts/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
                return;
            }
        }

        echo $content;
    }

    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $path): void {
        header('Location: ' . Helper::url($path));
        exit;
    }

    protected function validateCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'Validasi keamanan (CSRF Token) kadaluarsa. Silakan ulangi form.');
            $referer = $_SERVER['HTTP_REFERER'] ?? Helper::url();
            header("Location: $referer");
            exit;
        }
    }
}
