<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Roman\Converter\{Converter, InvalidRomanNumber, OutOfRomanBoundaries};

class ConverterTest extends TestCase
{
	private Converter $c;

	protected function setUp(): void
	{
		$this->c = new Converter();
	}

	public function singleRomanDigitsProvider(): array
	{
		return [
			['I', 1],
			['V', 5],
			['X', 10],
			['L', 50],
			['C', 100],
			['D', 500],
			['M', 1000],
		];
	}

	public function invalidRomanNumbersProvider(): array
	{
		return [
			'Empty string' => [''],
			'Unknown digit' => ['A'],
			'More of three of a same digit in a row' => ['IIII'],
		];
	}

	public function outOfRomanBoundariesNumberProvider(): array
	{
		return [
			[0],
			[-1],
			[4000],
		];
	}

	/**
	 * @dataProvider singleRomanDigitsProvider
	 */
	public function testSingleRomanDigit(string $roman_digit, int $int_value): void
	{
		$this->assertEquals($int_value, $this->c->toInt($roman_digit));
	}

	public function testTwoSameRomanDigits(): void
	{
		$this->assertEquals(2, $this->c->toInt('II'));
	}

	public function testLesserRomanDigitBeforeGreater(): void
	{
		$this->assertEquals(4, $this->c->toInt('IV'));
	}

	public function testCombinedRomanNumber(): void
	{
		$this->assertEquals(74, $this->c->toInt('LXXIV'));
	}

	/**
	 * @dataProvider invalidRomanNumbersProvider
	 */
	public function testExceptionForInvalidRomanNumbers(string $roman_number): void
	{
		$this->expectException(InvalidRomanNumber::class);

		$this->c->toInt($roman_number);
	}

	/**
	 * @dataProvider singleRomanDigitsProvider
	 */
	public function testIntToSingleDigitRoman(string $roman_digit, int $int_value): void
	{
		$this->assertEquals($roman_digit, $this->c->toRoman($int_value));
	}

	public function testIntToAddingDigitsRoman()
	{
		$this->assertEquals('XXIII', $this->c->toRoman(23));
	}

	public function testIntToRomanWithSubtraction()
	{
		$this->assertEquals('MCMXCIX', $this->c->toRoman(1999));
	}

	/**
	 * @dataProvider outOfRomanBoundariesNumberProvider
	 */
	public function testExceptionsForInvalidInt(int $number)
	{
		$this->expectException(OutOfRomanBoundaries::class);

		$this->c->toRoman($number);
	}
}
