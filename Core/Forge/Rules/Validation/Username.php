<?php

namespace Core\Forge\Rules\Validation;

class Username {
	/**
	 * Minimum Username Length
	 * @var int
	 */
	const int MIN_LENGTH = 5;

	/***
	 * Maximum Username Length
	 * @var int
	 */
	const int MAX_LENGTH = 20;

	/**
	 * Allowed characters in the username.
	 * As we don't want to store usernames in uppercase,
	 * let us just allow lowercase. We should convert all uppercase
	 * characters in the username to lowercase anyhow.
	 */
	const string ALLOWED_CHARACTERS = "@[a-z0-9]@";

	/**
	 * Check Username Length Complexity Requirements
	 *
	 * @param $Username
	 * @return bool
	 */
	private static function checkUsernameComplexityLength($Username) : bool {
		if (strlen($Username) < self::MIN_LENGTH || strlen($Username) > static::MAX_LENGTH) {
			return false;
		}

		return true;
	}

	/**
	 * Check Username Allowed Characters Complexity Requirements
	 *
	 * @param $Username
	 * @return bool
	 */
	private static function checkUsernameComplexityCharacters($Username) : bool {
		if (!preg_match(self::ALLOWED_CHARACTERS, $Username)) {
			return false;
		}

		return true;
	}

	/**
	 * Check username compliance
	 *
	 * @param string $Username
	 * @return bool
	 */
	public static function Validate(string $Username): bool {
		if (!static::checkUsernameComplexityLength($Username)) {
			return false;
		}

		if (!static::checkUsernameComplexityCharacters($Username)) {
			return false;
		}

		return true;
	}
}