<?php

if(!function_exists('isJson')) {
    /**
     * @param string $string
     * @return bool
     */
	function isJson($string) 
	{
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
	}
}