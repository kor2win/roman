<?php


namespace Roman\Converter;

class Converter
{
	private RomanNotationValidator $roman_validator;

	public function __construct()
	{
		$this->roman_validator = new RomanNotationValidator();
	}

	/**
	 * @param string $roman_notation
	 * @return int
	 * @throws InvalidRomanNumber
	 */
	public function toInt(string $roman_notation): int
	{
		$digits_sequence = str_split($roman_notation);

		$this->roman_validator->validateDigitsSequence($digits_sequence);

		$last_digit = $digits_sequence[count($digits_sequence) - 1];
		$total = $this->absoluteRomanDigitValue($last_digit);

		for ($i = 0; $i < count($digits_sequence) - 1; $i++) {
			$total += $this->relativeRomanDigitValue($digits_sequence[$i], $digits_sequence[$i + 1]);
		}

		return $total;
	}

	private function relativeRomanDigitValue(string $digit, string $next_digit): int
	{
		$v = $this->absoluteRomanDigitValue($digit);
		$next_v = $this->absoluteRomanDigitValue($next_digit);

		return $v < $next_v
			? -$v
			: +$v;
	}

	private function absoluteRomanDigitValue(string $d): int
	{
		return RomanDigitHelper::getNaturalValue($d);
	}
}