<?php

if (! function_exists('cdn')) {
    function cdn(string $path): string
    {
        return env('CDN_URL')."/$path";
    }
}
