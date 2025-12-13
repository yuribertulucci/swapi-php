<?php

if (!function_exists('response')) {
    /**
     * Create a new Response instance.
     *
     * @return \App\Http\Response
     */
    function response(string $text = null): \App\Http\Response
    {
        return new \App\Http\Response($text);
    }
}

if (!function_exists('request')) {
    /**
     * Create a new Request instance.
     *
     * @return \App\Http\Request
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

