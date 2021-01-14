<?php
use ReflectionClass as RC;

if (!function_exists('accessProtected')) {
	function accessProtected($obj, $prop) {
		if (is_object($obj)) {
			$reflection = new RC($obj);
	    	$property = $reflection->getProperty($prop);
	    	$property->setAccessible(true);
	    	return $property->getValue($obj);
		}
    }
}