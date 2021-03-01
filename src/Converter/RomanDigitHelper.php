<?php


namespace Roman\Converter;

class RomanDigitHelper
{
	CONST I = 'I';
	CONST V = 'V';
	CONST X = 'X';
	CONST L = 'L';
	CONST C = 'C';
	CONST D = 'D';
	CONST M = 'M';

	private function __construct()
	{
	}

	public static function getNaturalValue(string $digit): int
	{
		switch ($digit) {
			case self::I: return 1;
			case self::V: return 5;
			case self::X: return 10;
			case self::L: return 50;
			case self::C: return 100;
			case self::D: return 500;
			case self::M: return 1000;
		}
	}

	public static function isDigit(string $digit): bool
	{
		return $digit === self::I
			|| $digit === self::V
			|| $digit === self::X
			|| $digit === self::L
			|| $digit === self::C
			|| $digit === self::D
			|| $digit === self::M;
	}
}