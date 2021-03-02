<?php


namespace Roman\Converter;
use Roman\Converter\RomanDigitHelper as Roman;

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
		return Roman::getNaturalValue($d);
	}

	/**
	 * @param int $int_value
	 * @return string
	 * @throws OutOfRomanBoundaries
	 */
	public function toRoman(int $int_value): string
	{
		$this->validateConvertedInt($int_value);

		$remaining = $int_value;
		$roman_notation = '';

		foreach ($this->getRomanBases() as $roman_digit => $base) {
			$count = intdiv($remaining, $base);

			if ($count > 0) {
				$roman_notation .= str_repeat($roman_digit, $count);
				$remaining -= $base * $count;
			}
		}

		return $roman_notation;
	}

	/**
	 * @param int $int_value
	 * @throws OutOfRomanBoundaries
	 */
	private function validateConvertedInt(int $int_value): void
	{
		if ($int_value < 1 || $int_value > 3999) {
			throw new OutOfRomanBoundaries();
		}
	}

	private function getRomanBases(): array
	{
		static $roman_bases = [
			Roman::M => 1000,
			Roman::C . Roman::M => 900,
			Roman::D => 500,
			Roman::C . Roman::D => 400,
			Roman::C => 100,
			Roman::X . Roman::C => 90,
			Roman::L => 50,
			Roman::X . Roman::L => 40,
			Roman::X => 10,
			Roman::I . Roman::X => 9,
			Roman::V => 5,
			Roman::I . Roman::V => 4,
			Roman::I => 1,
		];

		return $roman_bases;
	}
}