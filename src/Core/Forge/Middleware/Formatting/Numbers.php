<?php

namespace Core\Forge\Middleware\Formatting;

class Numbers {
	/**
	 * Add th, st, nd, rd after a number.
	 * 		Example:
	 * 			1st
	 * 			2nd
	 * 			3rd
	 * 			4th
	 *
	 * @param int|float $Number
	 * @return string
	 */
	public static function Ordinal (int|float $Number): string {
		$Test = abs($Number) % 10;
		$Extension = ((abs($Number) % 100 < 21 && abs($Number) %100 > 4) ? 'th' : (($Test < 4) ? ($Test < 3) ? ($Test < 2) ? ($Test < 1) ? 'th' : 'st' : 'nd' : 'rd' : 'th'));

		return $Number.$Extension;
	}
}