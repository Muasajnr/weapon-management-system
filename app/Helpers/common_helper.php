<?php

if (!function_exists('pretty_print')) {
    function pretty_print($value) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}