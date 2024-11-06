<?php

namespace Core\Forge\Middleware\Restful\Manager;

/**
 * Based upon: https://medium.com/@selieshjksofficial/creating-and-managing-jwt-tokens-in-php-b6c1fc6c1b46
 */

class JWTManager {
	private static $SecretKey;

	public static function setSecretKey($Key): void {
		static::$SecretKey = $Key;
	}

	public static function createToken($Payload) {

	}

	public static function validateToken($Token) {

	}

	public static function decodeToken($Token) {

	}

	// Other helper functions for base64 URL encoding / decoding
}