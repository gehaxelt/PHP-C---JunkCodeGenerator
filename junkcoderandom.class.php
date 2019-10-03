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
		
		$charset= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString='';
		
		for($i=$length;$i>0;$i--)
			$randomString.=$charset[mt_rand(0,25)];
		
		// Check that the variables do not contain C++ (reserved) keywords
		if (preg_match('/(__has_cpp_attribute|__has_include|alignas|alignof|and|and_eq|asm|atomic_cancel|atomic_commit|atomic_noexcept|auto|bitand|bitor|bool|break|case|catch|char|char16_t|char32_t|char8_t|class|co_await|co_return|co_yield|compl|concept|const|const_cast|consteval|constexpr|constinit|continue|decltype|default|define|defined|delete|do|double|dynamic_cast|elif|else|else|endif|enum|error|explicit|export|extern|false|final|float|for|friend|goto|if|if|ifdef|ifndef|import|include|inline|int|line|long|module|mutable|namespace|new|noexcept|not|not_eq|nullptr|operator|or|or_eq|override|pragma|private|protected|public|reflexpr|register|reinterpret_cast|requires|return|short|signed|sizeof|static|static_assert|static_cast|struct|switch|synchronized|template|this|thread_local|throw|transaction_safe|transaction_safe_dynamic|true|try|typedef|typeid|typename|undef|union|unsigned|using|virtual|void|volatile|wchar_t|while|xor|xor_eq)/', $randomString)) {
			throw new IllegalNameException("Reserved keyword in randomString ${randomString}");
		}
		return $randomString;
	}
}
?>