<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Roman\Converter\{Converter, InvalidRomanNumber};

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

	/**
	 * @dataProvider singleRomanDigitsProvider
	 */
	public function testSingleRomanDigit(string $roman_digit, int $int_value): void
	{
		$this->assertEquals($int_value, $this->c->toInt($roman_digit));
	}

	public function testTwoSameRomanDigits()
	{
		$this->assertEquals(2, $this->c->toInt('II'));
	}

	public function testLesserRomanDigitBeforeGreater()
	{
		$this->assertEquals(4, $this->c->toInt('IV'));
	}

	public function testCombinedRomanNumber()
	{
		$this->assertEquals(74, $this->c->toInt('LXXIV'));
	}

	/**
	 * @dataProvider invalidRomanNumbersProvider
	 */
	public function testExceptionForInvalidRomanNumbers(string $roman_number)
	{
		$this->expectException(InvalidRomanNumber::class);

		$this->c->toInt($roman_number);
	}
}
