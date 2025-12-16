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