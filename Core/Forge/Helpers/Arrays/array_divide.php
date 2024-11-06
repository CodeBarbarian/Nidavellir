<?php
/**
 * @author: Morten Haugstad (CodeBarbarian)
 * @version: 1.0
 * @description: Returns two arrays, one containing the key of the array, the other containing the value. All from the
 * 				 original array.
 *
 * @note: This is based on the laravel function, but written using only the description of the function.
 * @package: nidavellir
 *
 * @info:
 * My attempt at the implementation of the Array Divide function from laravel.
 * Only based on the description of the function.
 * The array_divide function returns two arrays, one containing the keys, and the other containing the values of the original array
 *
 * This could also be a good programming exercise.
 */

function array_divide($Array) {
	// Interesting to see how this will work.
}

// Example to copy
list($keys, $values) = array_divide(['name' => 'Desk']);

var_dump($keys);
var_dump($values);

