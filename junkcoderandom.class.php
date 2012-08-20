<?php
include_once 'exceptions.junkcoderandom.class.php';

class JunkCodeRandom {
	
	/**
	 * Generates a random integer
	 * @param int $min - Minimum
	 * @param int $max - Maximum
	 * @throws NotAnIntegerException - if $min or $max are not an integer
	 * @return int - random number
	 */
	public function randomInteger($min,$max) {
		if(!is_int($min))
			throw new NotAnIntegerException('$min is not an integer');
		
		if(!is_int($max))
			throw new NotAnIntegerException('$max is not an integer');
		
		return mt_rand($min,$max);
	}
	
	/**
	 * Generates a random string
	 * @param int $length - Length of string to be generated
	 * @throws NotAnIntegerException - if $length is not an integer
	 * @return string - random string in small letters
	 */
	public function randomString($length) {
		if(!is_int($length))
			throw new NotAnIntegerException('$length is not an integer');
		
		$charset= 'abcdefghijklmnopqrstuvwxyz';
		$randomString='';
		
		for($i=$length;$i>0;$i--)
			$randomString.=$charset[mt_rand(0,25)];
		
		return $randomString;
	}
}
?>