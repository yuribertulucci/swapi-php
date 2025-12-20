<?php

if (!function_exists('response')) {
    /**
     * Create a new Response instance.
     */
    function response(string $text = null): \App\Http\Response
    {
        return new \App\Http\Response($text);
    }
}

if (!function_exists('request')) {
    /**
     * Create a new Request instance.
     */
    function request(): \App\Http\Request
    {
        return \App\Http\Request::instance();
    }
}


if (!function_exists('obj2array')) {
    function obj2array(&$Instance): array
    {
        $clone = (array) $Instance;
        $rtn = array();
        $rtn['___SOURCE_KEYS_'] = $clone;

        foreach ($clone as $key => $value) {
            $aux = explode("\0", $key);
            $newkey = $aux[count($aux) - 1];
            $rtn[$newkey] = &$rtn['___SOURCE_KEYS_'][$key];
        }

        array_shift($rtn);
        return $rtn;
    }
}

if (!function_exists('app_path')) {
    /**
     * Get the application path.
     */
    function app_path($path = ''): string
    {
        return \App\Core\Application::instance()->getBasePath() . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

if (! function_exists('view')) {
    /**
     * Create a new view instance.
     */
    function view(string $view = null, array $data = []): \App\Http\Response
    {
        return response()->view($view, $data);
    }
}

if (! function_exists('encode')) {
    /**
     * Encode data to html.
     */
    function encode($data): string
    {
        // Convert objects and arrays to string representation for debugging purposes
        if (is_object($data)) {
            $data = get_class($data) . ' ' . ltrim(var_export(obj2array($data), true), 'array');
        } elseif (is_array($data)) {
            $data = var_export($data, true);
        }

        return htmlspecialchars($data ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (! function_exists('route')) {
    /**
     * Generate a URL for a named route.
     */
    function route(string $name, array $params = []): string
    {
        return \App\Routing\Router::instance()->generateUrl($name, $params) ?? '';
    }
}

if (! function_exists('env')) {
    /**
     * Get the value of an environment variable.
     */
    function env(string $key, $default = null)
    {
        return \App\Core\Application::instance()->getEnv($key, $default);
    }
}

if (! function_exists('asset')) {
    /**
     * Generate a URL for an asset.
     */
    function asset(string $path): string
    {
        $baseUrl = env('APP_URL', 'http://localhost' . ':' . env('APP_PORT', '8010'));
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}