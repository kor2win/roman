<?php


namespace Roman\Converter;

class RomanNotationValidator
{
	/**
	 * @param string[] $digits_sequence
	 * @throws InvalidRomanNumber
	 */
	public function validateDigitsSequence(array $digits_sequence): void
	{
		$this->validateLength($digits_sequence);
		$this->validateAlphabet($digits_sequence);
		$this->validateSameDigitSubsequenceLength($digits_sequence);
	}

	/**
	 * @param string[] $digits_sequence
	 * @throws InvalidRomanNumber
	 */
	private function validateLength(array $digits_sequence): void
	{
		if (count($digits_sequence) === 0) {
			throw new InvalidRomanNumber('An empty number');
		}
	}

	/**
	 * @param string[] $digits_sequence
	 * @throws InvalidRomanNumber
	 */
	private function validateAlphabet(array $digits_sequence): void
	{
		foreach ($digits_sequence as $d) {
			if (!RomanDigitHelper::isDigit($d)) {
				throw new InvalidRomanNumber('Contains unknown digit');
			}
		}
	}

	/**
	 * @param string[] $digits_sequence
	 * @throws InvalidRomanNumber
	 */
	private function validateSameDigitSubsequenceLength(array $digits_sequence)
	{
		$count = 1;
		$previous = $digits_sequence[0];

		for ($i = 1; $i < count($digits_sequence); $i++) {
			$current = $digits_sequence[$i];

			if ($previous === $current) {
				$count++;

				if ($count === 4) {
					throw new InvalidRomanNumber('More of three of a same digit in a row');
				}
			} else {
				$count = 1;
			}

			$previous = $current;
		}
	}
}